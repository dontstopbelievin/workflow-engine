<?php

namespace App\Http\Controllers;

use App\User;
use App\Process;
use App\Role;
use App\Log;
use App\Status;
use App\CityManagement;
use App\Comment;
use App\CreatedTable;
use App\Template;
use Mpdf\Mpdf;
use App\TemplateField;
use App\Traits\dbQueries;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Notification;
use App\Notifications\ApproveNotification;
use Mpdf\Output\Destination;
use PDF;
use QrCode;

class ApplicationController extends Controller
{
    use dbQueries;

    public function service()
    {
        $processes = Process::all();
        $modalPopup = User::where('name', 'Admin')->first()->has_not_accepted_agreement;

        return view('application.dashboard', compact('processes', 'modalPopup'));
    }

    public function index(Process $process)
    {
        $tableName = $this->getTableName($process->name);
        $applications = $this->getTableWithStatuses($tableName);
        $arrayApps = json_decode(json_encode($applications), true);

        foreach($arrayApps as &$app) {
          if ($app["to_revision"] === 1) {
              $app["status"] = $app["status"] . " на доработку";
          } else if($app["reject_reason"] != null) {
              $app["status"] = $app["status"] . " на согласование отказа";
          }else{
            $app["status"] = $app["status"] . " на согласование";
          }
        }
        $statuses = [];
        return view('application.index', compact('arrayApps', 'process','statuses'));
    }

    public function view($processId, $applicationId)
    {
        $process = Process::find($processId);
        $templateId = $process->accepted_template_id;
         $templateFields= TemplateField::where('template_id', $templateId)->get();
        $tableName = $this->getTableName($process->name);
        $table = CreatedTable::where('name', $tableName)->first();
        $application = DB::table($tableName)->where('id', $applicationId)->first();
        $applicationArray = json_decode(json_encode($application), true);
        $notInArray = ["id", "process_id", "status_id", "to_revision", "user_id","index_sub_route", "index_main", "revision_reason" ];
//        $applicationArray = $this->filterApplicationArray($applicationArray, $notInArray); // not used yet, but surely will

        $statusId = $application->status_id;
        $user = Auth::user();
        $thisRole = $user->role;
        $subRoutes = $this->getSubRoutes($process->id);
        if (!$user->role) {
            echo 'Дайте роль юзеру';
            return;
        }
        $comments = $this->getComments($application->id, $table->id);
        $roleId = $thisRole->id; //роль действующего юзера
        $records = $this->getRecords($application->id, $table->id);
        $canApprove = $roleId === $statusId; //может ли специалист подвисывать услугу
        $isCurrentUserRoleInParallel = $this->checkIfCurrentUserRoleInParallel($process);
        //parallel approve
        $toMultipleRoles["exists"] = false;
        if ($canApprove && !$isCurrentUserRoleInParallel) { // if not in parallel
            $appRoutes = json_decode($this->getAppRoutes($application->process_id));
            $index = $application->index_main;

            $multipleOptions = [];
            if (isset($appRoutes[$index])) {
                $nextRole = $appRoutes[$index];
                $multipleOptions = $this->hasMultipleOptions($process, $nextRole);
            }

            if (empty($multipleOptions)) {
                $toMultipleRoles["exists"] = false;
            } else {
                $toMultipleRoles["exists"] = true;
                $toMultipleRoles["roleOptions"] = $multipleOptions;
            }
        }

        $toCitizen = false;
        $backToMainOrg = false;
        $userRole = Role::find($roleId);
        $appRoutes = json_decode($this->getAppRoutes($process->id));
        $indexMain = $application->index_main;
        if ($appRoutes[sizeof($appRoutes)-1] === $userRole->name && $indexMain !== 1) { // add i && ndex != 1
            $toCitizen = true; // если заявку подписывает последний специалист в обороте, заявка идет обратно к заявителю
        }
        if (!empty($subRoutes)) {
            if($subRoutes[sizeof($subRoutes) - 1] === $userRole->name) {
                $backToMainOrg = true;
            }
        }
        // Обработка причины и участников доработки
        $fromRole = Role::where('id', $application->revision_reason_from_spec_id)->first(); // кто отправил на доработку
        $toRole = Role::where('id', $application->revision_reason_to_spec_id)->first(); // кому отправили на доработку
        $revisionReasonArray = [];
        $revisionReasonArray["revisionReason"] = $application->revision_reason;
        if (isset($fromRole)) {
            $revisionReasonArray["fromRole"] = $fromRole->name;
        } else {
            $revisionReasonArray["fromRole"] = Null;
        }
        if (isset($fromRole)) {
            $revisionReasonArray["toRole"] = $toRole->name;
        } else {
            $revisionReasonArray["toRole"] = Null;
        }
        //
        // Обработка причины отказа
        $rejectFromRole = Role::where('id', $application->reject_reason_from_spec_id)->first(); // кто отправил на отказ
        $rejectReasonArray = [];
        $rejectReasonArray["rejectReason"] = $application->reject_reason;
        if (isset($rejectFromRole)) {
            $rejectReasonArray["fromRole"] = $rejectFromRole->name;
        } else {
            $rejectReasonArray["fromRole"] = Null;
        }
        //
        $sendToSubRoute = [];
        $sendToSubRoute["isset"] = false;
        if (Null !==($process->roles()->where('parent_role_id', '<>', Null)->first())) {
            $parentRoleId = intval($process->roles()->where('parent_role_id', '<>', Null)->first()->pivot->parent_role_id); // добыть родительскую айдишку родительской роли для подролей
            $subOrg = CityManagement::find($process->support_organization_id);

            if (($application->index_sub_route > 0) && ($application->index_sub_route < sizeof($subRoutes))) {
                if ($thisRole->name === $subRoutes[$application->index_sub_route - 1]) {
                    $sendToSubRoute["isset"] = true;
                    if (isset($subOrg->name)) {
                        $sendToSubRoute["name"] = $subOrg->name;
                    }
                }
            }
            if ($parentRoleId === $thisRole->id)  {
                $sendToSubRoute["isset"] = true;
                if (isset($subOrg->name)) {
                    $sendToSubRoute["name"] = $subOrg->name;
                }
            }
        }

        if (!$thisRole->city_management_id) {
            echo 'Укажите к какой организации относить роль';
            return;
        }
        $nameUpr = CityManagement::find($thisRole->city_management_id)->name;
        $mainRoles = $this->getIterateRoles($process);
        $subRoles = $this->getSubRoutes($process->id);
        $allRoles = $this->mergeRoles($mainRoles, $subRoles);

        $templateId = $process->accepted_template_id;
        $template = Template::where('id', $templateId)->first();
        $templateName = $template->name;

        $templateTable = $this->getTemplateTableName($templateName);
        $templateTableFields = [];
        if (Schema::hasTable($templateTable)) {
            if (Schema::hasColumn($templateTable, 'template_id') && (Schema::hasColumn($templateTable, 'process_id')) && Schema::hasColumn($templateTable, 'application_id')) {
                $templateTableFields = DB::table($templateTable)
                    ->where('process_id', $process->id)
                    ->where('application_id', $application->id)
                    ->where('template_id', $templateId)
                    ->get()->toArray();
                $templateTableFields = json_decode($templateTableFields, true);
                $exceptionArray = ["id", "template_id", "process_id", "application_id"];
                $templateTableFields = $this->filterTemplateFieldsTable($templateTableFields, $exceptionArray);
            }
        }
        // изменения Дильназ

        $buttons = DB::table('process_role')
                  ->where('process_id', $process->id)
                  ->where('role_id', $user->role_id)
                  ->get()
                  ->toArray();

        if(isset($buttons[0]) && $rejectReasonArray['rejectReason'] != null){
          $buttons[0]->can_reject = 0;
        }

        // конец
        //dd($rejectReasonArray);
        return view('application.view', compact('application','toMultipleRoles','templateTableFields','templateFields', 'process','canApprove', 'toCitizen','sendToSubRoute', 'backToMainOrg','allRoles','comments','records','revisionReasonArray','rejectReasonArray', 'buttons'));
    }

    public function acceptAgreement(Request $request)
    {
        if ($request->accepted) {
            $user = Auth::user();
            $user->has_not_accepted_agreement = false;
            $user->update();
//            return Redirect::route('applications.service');
        }
//        return Redirect::route('applications.service');
    }

    private function hasMultipleOptions($process, $role)
    {
        $parallelRoles = $process->roles()->where('is_parallel', '<>', 0)->get();
        $parallelRole = $parallelRoles->where('name', $role)->first();
        $pRolesArr = [];
        if (isset($parallelRole->pivot->is_parallel)) {
            $isParallelInt = $parallelRole->pivot->is_parallel;

            foreach($parallelRoles as $pRole) {
                if ($pRole->pivot->is_parallel === $isParallelInt) {
                    array_push($pRolesArr, $pRole);
                }
            }

        }
        return $pRolesArr;
    }

    private function checkIfCurrentUserRoleInParallel($process)
    {
        $parallelRoles = $process->roles()->where('is_parallel', '<>', 0)->get()->pluck('name')->toArray();
        $role = Auth::user()->role->name;
        return in_array($role, $parallelRoles);
    }
    public function approveReject(Request $request){

      $process = Process::find($request->processId);
      $tableName = $this->getTableName($process->name);
      $application = DB::table($tableName)->where('id', $request->applicationId)->first();
      $table = CreatedTable::where('name', $tableName)->first();

      $index = $application->index_main;
      $appRoutes = json_decode($this->getAppRoutes($application->process_id));
      //dd($appRoutes);
      $nextRole = $appRoutes[$index]; // find next role

      $nextR = Role::where('name', $nextRole)->first(); //find $nextRole in Role table
      $idOfNextRole = $nextR->id; // get id of next role
      $index = $index + 1;
      $status = Status::find($idOfNextRole);
      //dd($status);
      $user = Auth::user();
      $role = $user->role;
      $logsArray = $this->getLogs($status->id, $table->id, $application->id, $role->id);

      DB::table('logs')->insert( $logsArray);
      $this->insertComments($request->comments, $request->applicationId, $table->id);
      if ($application->to_revision === 0) {
          DB::table($tableName)
              ->where('id', $request->applicationId)
              ->update(['status_id' => $status->id, 'index_main' => $index]);
      } else {
          DB::table($tableName)
              ->where('id', $request->applicationId)
              ->update(['status_id' => $status->id, 'index_main' => $index,'to_revision' => 0 ]);
      }
    }

    public function approve(Request $request)
    {
//        dd($request->all());
        $requestVal = $request->all();
        for ($i = 0; $i <=2; $i ++) {
            array_shift($requestVal);
        }
        $fieldValues = $requestVal;

        foreach($fieldValues as $key=>$val) {
            if (is_file($val)) {
                $path = $request->file($key)->store('application-docs','public');
                $fieldValues[$key] = $path;
            }
        }
        $process = Process::find($request->process_id);
        $tableName = $this->getTableName($process->name);
        $application = DB::table($tableName)->where('id', $request->applicationId)->first();
        $table = CreatedTable::where('name', $tableName)->first();
        $templateId = $process->accepted_template_id;
        $template = Template::where('id', $templateId)->first();
        $templateName = $template->name;
        $templateTable = $this->getTemplateTableName($templateName);

        // insertion of fields into template
        $this->insertTemplateFields($fieldValues, $templateTable, $process->id, $application->id, $templateId);
        $role = Auth::user()->role;

        $isCurrentUserRoleInParallel = $this->checkIfCurrentUserRoleInParallel($process);
        if ($isCurrentUserRoleInParallel) {
            $roleAfterParallelWithIndex = $this->getRoleAfterParallel($process);
            if(isset($roleAfterParallelWithIndex)){
                $roleAfterParallel = $roleAfterParallelWithIndex["roleAfterParallel"];
                $index = $roleAfterParallelWithIndex["index"];
                $status = Status::find($roleAfterParallel["id"]);
                $logsArray = $this->getLogs($status->id, $table->id, $application->id, $role["id"]);
            }else{
                //check if all accept then send to citizen
            }
        } else {
            $index = $application->index_main;
            $appRoutes = json_decode($this->getAppRoutes($application->process_id));
            $nextRole = $appRoutes[$index]; // find next role
            $nextR = Role::where('name', $nextRole)->first(); //find $nextRole in Role table
//            $notifyUsers = $nextR->users();
            $idOfNextRole = $nextR->id; // get id of next role
            $index = $index + 1;
            $status = Status::find($idOfNextRole);
            $logsArray = $this->getLogs($status->id, $table->id, $application->id, $role->id);
        }
        Log::insert( $logsArray);

        $this->insertComments($request->comments, $request->applicationId, $table->id);
        if ($application->to_revision === 0) {
            DB::table($tableName)
                ->where('id', $request->applicationId)
                ->update(['status_id' => $status->id, 'index_main' => $index]);
        } else {
            DB::table($tableName)
                ->where('id', $request->applicationId)
                ->update(['status_id' => $status->id, 'index_main' => $index,'to_revision' => 0 ]);
        }
//         $notifyUsers = $role->users;
//         foreach($notifyUsers as $notifyUser) {
//             $details = [

//                 'greeting' => 'Привет' . ', ' . $notifyUser->name,

//                 'body' => 'Это уведомление о том, что Вы должны согласовать заявку',

//                 'thanks' => 'Пожалуйста, зайтите на портал и согласуйте услугу',

//                 'actionText' => 'Workflow Engine',
// //
//                 'actionURL' => url('/services'),
// //
//                 'order_id' => 101

//             ];
//             Notification::send($notifyUser, new ApproveNotification($details));
//         }
        return Redirect::route('applications.service')->with('status', $status->name);
    }

    public function multipleApprove(Request $request)
    {
        $requestVal = $request->all();
        $processId = $request->processId;
        $applicationId = $request->applicationId;
        $role = $request->role;
        $fieldValues = array_slice($requestVal, 4);
        if ($fieldValues) {
            foreach($fieldValues as $key=>$val) {
                if (is_file($val)) {
                    $path = $request->file($key)->store('application-docs','public');
                    $fieldValues[$key] = $path;
                }
            }
        }

        $process = Process::find($processId);
        $templateId = $process->accepted_template_id;
        $template = Template::where('id', $templateId)->first();
        $templateName = $template->name;
        $templateTable = $this->getTemplateTableName($templateName);
        $tableName = $this->getTableName($process->name);
        $table = CreatedTable::where('name', $tableName)->first();
        $application = DB::table($tableName)->where('id', $applicationId)->first();
        $this->insertTemplateFields($fieldValues, $templateTable, $process->id, $application->id, $templateId);
//        dd('inserted');
        $index = $application->index_main;
        $appRoutes = json_decode($this->getAppRoutes($application->process_id));
        $nextRole = Role::where('id', $role)->first();
        $nextRoleId = $nextRole->id;
        $updatedStatus = Status::where('id', $nextRoleId)->first();
        $pos = array_search($nextRole->name, $appRoutes);

        $index = $index + $pos;
        $role = Auth::user()->role;
        $logsArray = $this->getLogs($updatedStatus->id, $table->id, $application->id, $role->id);
        Log::insert( $logsArray);
        $success = DB::table($tableName)
            ->where('id', $applicationId)
            ->update(['status_id' => $updatedStatus->id, 'index_main' => $index]);
        return Redirect::route('applications.service')->with('status', $updatedStatus->name);
    }

    public function create(Process $process)
    {
        $tableName = $this->getTableName($process->name);
        $notInclude = ['id', 'process_id', 'status_id', 'user_id', 'index_sub_route', 'index_main', 'doc_path', 'reject_reason', 'reject_reason_from_spec_id', 'to_revision', 'revision_reason', 'revision_reason_from_spec_id', 'revision_reason_to_spec_id', 'updated_at'];
        $tableColumns = $this->getColumns($tableName, $notInclude);
        $originalTableColumns = $this->getOriginalColumns($tableColumns);
        $dictionaries = $this->getAllDictionaries();
        $res = [];

        foreach($dictionaries as $item) {
            foreach($originalTableColumns as $column) {
                if($item["name"] === $column) {
                    array_push($res, $item);
                }
            }
        }
        $dictionariesWithOptions = $this->addOptionsToDictionary($res);
        $arrayToFront = $this->getAllDictionariesWithOptions($dictionariesWithOptions);

        return view('application.create', compact('process', 'arrayToFront'));
    }

    public function store(Request $request)
    {

        $input = $request->input();
        if ($request->hasFile('attachment')) {
            $input["attachment"] = $request->file('attachment')->store('applicant-attachments','public');
        }
        $applicationTableFields = $input;
        if(isset($applicationTableFields['_token'])){
            unset($applicationTableFields['_token']);
        }
        $process = Process::find($request->process_id);
        $routes = $this->getRolesWithoutParent($process->id);
        $arrRoutes = json_decode($routes, true);
        $status = Status::find($arrRoutes[0]["id"]);

//         $notifyUsers = $role->users;
// //        dd($notifyUsers, $role);
//         foreach($notifyUsers as $notifyUser) {
// //            dd($notifyUser);
//             $details = [

//                 'greeting' => 'Привет' . ', ' . $notifyUser->name,

//                 'body' => 'Это уведомление о том, что Вы должны согласовать заявку',

//                 'thanks' => 'Пожалуйста, зайтите на портал и согласуйте услугу',

//                 'actionText' => 'Workflow Engine',
// //
//                 'actionURL' => url('/services'),
// //
//                 'order_id' => 101

//             ];
//             Notification::send($notifyUser, new ApproveNotification($details));
//         }
//        dd($notifyUsers);
        $tableName = $this->getTableName($process->name);
        $table = CreatedTable::where('name', $tableName)->first();
        $user = Auth::user();
//        dd($applicationTableFields);
        $modifiedApplicationTableFields = $this->modifyApplicationTableFields($applicationTableFields, $status->id, $user->id);
        $applicationId = DB::table($tableName)->insertGetId($modifiedApplicationTableFields);
        $logsArray = $this->getFirstLogs($status->id, $table->id, $applicationId, $arrRoutes[0]["id"]); // получить историю хода согласования
        Log::insert($logsArray);

        return Redirect::route('applications.service')->with('status', 'Заявка Успешно создана');
    }

    public function download($file)
    {
        echo ($file);
        $path = storage_path().'/'.'app/'.$path;
        dd($path);
        if (file_exists($path)) {
            return response()->download($path);
        }
    }

    public function search(Request $request)
    {
        $process = Process::find($request->processId);
        $routes = $this->getRolesWithoutParent($process->id);
        $arrRoutes = json_decode($routes, true);
        $status = Status::find($arrRoutes[0]["id"]);

        $tableName = $this->getTableName($process->name);
        $table = CreatedTable::where('name', $tableName)->first();
        $user = Auth::user();

        $aData = ["coordindates" => "5645226",   "goal" => "123213213", "area" => "34123453", "processId" => $process->id];
        $applicationTableFields["coordindates"] = $aData["coordindates"];
        $applicationTableFields["goal"] = $aData["goal"];
        $applicationTableFields["area"] = $aData["area"];
//        dd($aData, $applicationTableFields);
        $modifiedApplicationTableFields = $this->modifyApplicationTableFields($applicationTableFields, $status->id, $user->id);
        $applicationId = DB::table($tableName)->insertGetId( $modifiedApplicationTableFields);
        $logsArray = $this->getFirstLogs($status->id, $table->id, $applicationId, $arrRoutes[0]["id"]); // получить историю хода согласования
        Log::insert($logsArray);

        return Redirect::route('applications.service')->with('status', 'Заявка Успешно создана');
    }

    public function sendToSubRoute(Request $request)
    {
        $fieldValues = $request->fieldValues;
        $process = Process::find($request->processId);
        $tableName = $this->getTableName($process->name);
        $application = DB::table($tableName)->where('id', $request->applicationId)->first();
        $table = CreatedTable::where('name', $tableName)->first();
        $subRoutes = $this->getSubRoutes($process->id);
        $index = $application->index_sub_route;
        $nextRole = $subRoutes[$index];
        $nextR = Role::where('name', $nextRole)->first();
        $idOfNextRole = $nextR->id;
        $index = $index + 1;
        $status = Status::find($idOfNextRole);
        $user = Auth::user();
        $role = $user->role;

        $this->insertComments($request->comments, $request->applicationId, $table->id);
        $templateId = $process->accepted_template_id;
        $template = Template::where('id', $templateId)->first();
        $templateName = $template->name;
        $templateTable = $this->getTemplateTableName($templateName);
        $this->insertTemplateFields($fieldValues, $templateTable, $process->id, $application->id, $templateId);
        $logsArray = $this->getLogs($status->id, $table->id, $application->id, $role->id);
        Log::insert( $logsArray);

        if ($application->to_revision === 0) {
            DB::table($tableName)
                ->where('id', $request->applicationId)
                ->update(['status_id' => $status->id, 'index_sub_route' => $index]);
        } else {
            DB::table($tableName)
                ->where('id', $request->applicationId)
                ->update(['status_id' => $status->id, 'index_sub_route' => $index, 'to_revision' => 0]);
        }
        return Redirect::route('applications.service')->with('status', $status->name);
    }

    public function backToMainOrg($id, Request $request)
    {
        $process = Process::find($request->process_id);
        $tableName = $this->getTableName($process->name);
        $table = CreatedTable::where('name', $tableName)->first();
        $application = DB::table($tableName)->where('id', $id)->first();
        $parentId = $this->getParentRoleId($process->id);
        $parentRole = Role::find($parentId);
        $status = Status::find($parentId);

        $user = Auth::user();
        $role = $user->role;

        $logsArray = $this->getLogs($status->id, $table->id, $application->id, $role->id);
        Log::insert( $logsArray);

        DB::table($tableName)
            ->where('id', $id)
            ->update(['status_id' => $status->id, 'index_sub_route' => Null]);
        return Redirect::route('applications.service')->with('status', $status->name);
    }

    public function toCitizen($id, Request $request)
    {
        $applicationId = $request->application_id;
        $process = Process::find($request->process_id);
        $fieldValues = $request->fieldValues;
        $tableName = $this->getTableName($process->name);
        $application = DB::table($tableName)->where('id', $applicationId)->first();
        $table = CreatedTable::where('name', $tableName)->first();
        $templateId = $process->accepted_template_id;
        $template = Template::where('id', $templateId)->first();
        $templateName = $template->name;
        $templateTable = $this->getTemplateTableName($templateName);
        if (Schema::hasTable($templateTable)) {
            $fields = DB::table($templateTable)->select('*')->where('application_id', $applicationId)->first();
            $aFields = json_decode(json_encode($fields), true);

            $updatedFields = [];
            if ($aFields !== Null) {
                foreach($aFields as $key => $field) {
                    if ($key === 'id' || $key === 'template_id' || $key === 'process_id' || $key === 'application_id' || $key === '_token') {
                        continue;
                    }
                    $updatedFields[$key] = $field;
                }
            }

            $fileName = $this->generateRandomString();
            $docPath = 'final_docs/'. $fileName . '.pdf';
            $todayDate=date('d-m-Y');
            $updatedFields["date"] = $todayDate;
            $updatedFields["id"] = $applicationId;
            $updatedFields["applicant_name"] = 'Аман';
            $updatedFields["area"] = '114 га';
            $updatedFields["square"] = 'Байконур';
            $updatedFields["street"] = 'Кабанбай батыра';
            $updatedFields["duration"] = '12';
            $updatedFields["object_name"] = 'object_name';
            $updatedFields["cadastral_number"] = '1146';
            $updatedFields["construction_name_before"] = '1146';
            $updatedFields["construction_name_after"] = '1146';
            $updatedFields["area_number"] = '1146';
            $updatedFields["construction_name_before"] = 'Строительство';
            $updatedFields["construction_name_after"] = 'Делопроизводство';
            $updatedFields["area_number"] = '1146';
            $userName = Auth::user()->name;
            $roleName = Auth::user()->role->name;
            $pathToView = $process->template_doc->pdf_path;
            $storagePathToPDF ='/app/public/final_docs/' . $fileName . '.pdf';

            $content = view($pathToView, compact('updatedFields', 'userName', 'roleName'))->render();
            $mpdf = new Mpdf();
            $mpdf->WriteHTML($content);
            $mpdf->Output(storage_path(). $storagePathToPDF, \Mpdf\Output\Destination::FILE);
            // return view('pdf_viewer')->with('my_pdf', $content);
            $affected = DB::table($tableName)
                ->where('id', $id)
                ->update(['doc_path' => $docPath]);
            // dd('done');
        }

        if ($fieldValues !== Null) {
            $this->insertTemplateFields($fieldValues, $templateTable, $process->id, $application->id, $templateId);
        }

        $tableName = $this->getTableName($process->name);
        $statusCount = count(Status::all());
        $status = Status::find($statusCount);
        $table = CreatedTable::where('name', $tableName)->first();
        $application = DB::table($tableName)->where('id', $id)->first();
        $role = Auth::user()->role;
        $logsArray = $this->getLogs($status->id, $table->id, $application->id, $role->id);
        Log::insert( $logsArray);
        $affected = DB::table($tableName)
            ->where('id', $id)
            ->update(['status_id' => $status->id, 'index_main' => Null]);

        return Redirect::route('applications.service')->with('status', $status->name);
    }

    function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function reject(Request $request)
    {
        $process = Process::find($request->processId);
        $tableName = $this->getTableName($process->name);
        $application = DB::table($tableName)->where('id', $request->applicationId)->first();
        $table = CreatedTable::where('name', $tableName)->first();

        $index = $application->index_main;
        $appRoutes = json_decode($this->getAppRoutes($application->process_id));
        $nextRole = $appRoutes[$index]; // find next role
        $nextR = Role::where('name', $nextRole)->first(); //find $nextRole in Role table
        $idOfNextRole = $nextR->id; // get id of next role
        $index = $index + 1;
        $status = Status::find($idOfNextRole);

        $user = Auth::user();
        //dd($user);
        $role = $user->role;

        $logsArray = $this->getLogs($status->id, $table->id, $application->id, $role->id);

        Log::insert( $logsArray);

        if ($application->to_revision === 0) {
            DB::table($tableName)
                ->where('id', $request->applicationId)
                ->update(['status_id' => $status->id, 'index_main' => $index, 'reject_reason' => $request->rejectReason, 'reject_reason_from_spec_id' => $user->role_id]);
        } else {
            DB::table($tableName)
                ->where('id', $request->applicationId)
                ->update(['status_id' => $status->id, 'index_main' => $index, 'reject_reason' => $request->rejectReason, 'to_revision' => 0, 'reject_reason_from_spec_id' => $user->role_id]);
        }
    }

    public function revision(Request $request)
    {
        $roleToRevise = $request->roleToRevise; //Роль, которому форма отправляется на доработку
        $mainCounter = 0;
        $subCounter = 0;
        $index = 0;
        $indexSubRoute = 0;
        $process = Process::find($request->processId);
        $tableName = $this->getTableName($process->name);
        $mainRoles = $this->getIterateRoles($process); // get collection
        $mainRoleArr = $this->getMainRoleArray($mainRoles); // get array of names from collection
        $subRoles = $this->getSubRoutes($process->id);

        foreach($mainRoleArr as $role) {
            $mainCounter++;
            if ($role === $roleToRevise) {
                $index = $mainCounter;
                break;
            }
        }
        if ($index === 0) {
            foreach($subRoles as $role) {
                $subCounter++;
                if ($role === $roleToRevise) {
                    $indexSubRoute = $subCounter;
                    break;
                }
            }
        }

        $nextR = Role::where('name', $roleToRevise)->first();
        $idOfNextRole = $nextR->id;
        $status = Status::find($idOfNextRole);
        $user = Auth::user();
        $role = $user->role;
        $table = CreatedTable::where('name', $tableName)->first();
        $application = DB::table($tableName)->where('id', $request->applicationId)->first();
        $logsArray = $this->getLogs($status->id, $table->id, $application->id, $role->id);
        Log::insert( $logsArray);

        if ($index === 0) {
            DB::table($tableName)
                ->where('id', $request->applicationId)
                ->update(['status_id' => $status->id, 'revision_reason' => $request->revisionReason,'to_revision' => 1,'index_sub_route' => $indexSubRoute, 'revision_reason_from_spec_id' =>  $user->role_id, 'revision_reason_to_spec_id' =>  $idOfNextRole] );
        } else {
            DB::table($tableName)
                ->where('id', $request->applicationId)
                ->update(['status_id' => $status->id, 'revision_reason' => $request->revisionReason,'to_revision' => 1, 'index_main' => $index, 'revision_reason_from_spec_id' =>  $user->role_id, 'revision_reason_to_spec_id' =>  $idOfNextRole] );
        }
    }

    private function getRoleAfterParallel($process)
    {
        $roleWithIndex = [];
        $allRoles = $process->roles()->get()->toArray();
        $isParallel = false;
//        $roleAfterParallel = 0;
        $index = 0;
        // dd($allRoles);
        foreach($allRoles as $role) {
            $index++;
            if ($isParallel && $role["pivot"]["is_parallel"] === 0) {
                $roleWithIndex["roleAfterParallel"] = $role;
                break;
            }
            if ($role["pivot"]["is_parallel"] !== 0) {
                $isParallel = true;
            }
        }
        $roleWithIndex["index"] = $index;
        return $roleWithIndex;
    }

    private function getLogs($statusId, $tableId, $applicationId, $roleId)
    {
        $logsArray = [];
        $logsArray["status_id"] = $statusId;
        $logsArray["role_id"] = $roleId;
        $logsArray["table_id"] = $tableId;
        $logsArray["application_id"] = $applicationId;
        $logsArray["created_at"] = Carbon::now();
        return $logsArray;
    }

    private function getFirstLogs($statusId, $tableId, $applicationId, $roleId)
    {
        $logsArray = [];
        $logsArray["status_id"] = $statusId;
        $logsArray["role_id"] = 1;
        $logsArray["table_id"] = $tableId;
        $logsArray["application_id"] = $applicationId;
        $logsArray["created_at"] = Carbon::now();
        return $logsArray;
    }

    private function insertComments($comments, $applicationId, $tableId)
    {
        if ($comments !== Null) {
            $comment = new Comment( [
                'name' => $comments,
                'application_id' => $applicationId,
                'table_id' => $tableId,
                'role_id' => Auth::user()->role->id,
            ]);
            $comment->save();
        }
    }

    private function filterTemplateFieldsTable($array, $exceptionArray)
    {
        $res = [];
        foreach($array as $item) {
            foreach($item as $key=>$value) {
                if (!in_array($key, $exceptionArray)) {
                    $res[$key] = $value;
                }
            }
        }
        return $res;
    }

    private function modifyApplicationTableFields($applicationTableFields, $statusId, $userId)
    {
        $applicationTableFields["status_id"] = $statusId;
        $applicationTableFields["user_id"] = $userId;
        $applicationTableFields["index_main"] = 1;
        $applicationTableFields["index_sub_route"] = 0;
        return $applicationTableFields;
    }

    private function insertTemplateFields($fieldValues, $templateTable,$processId, $applicationId, $templateId)
    {
        if (!Schema::hasTable($templateTable)) {
            $dbQueryString = "CREATE TABLE $templateTable (id INT PRIMARY KEY AUTO_INCREMENT)";
            DB::statement($dbQueryString);
        }
        foreach($fieldValues as $key=>$value) {
            if (Schema::hasColumn($templateTable, $key)) {
                continue;
            } else {
                $dbQueryString = "ALTER TABLE $templateTable ADD COLUMN $key varchar(255)";
                DB::statement($dbQueryString);
            }
        }
        if (!Schema::hasColumn($templateTable, 'template_id')) {
            $dbQueryString = "ALTER TABLE $templateTable ADD  template_id INT";
            DB::statement($dbQueryString);
        }
        if (!Schema::hasColumn($templateTable, 'process_id')) {
            $dbQueryString = "ALTER TABLE $templateTable ADD  process_id INT";
            DB::statement($dbQueryString);
        }
        if (!Schema::hasColumn($templateTable, 'application_id')) {
            $dbQueryString = "ALTER TABLE $templateTable ADD  application_id INT";
            DB::statement($dbQueryString);
        }
        $checkRow = DB::table($templateTable)
            ->where('process_id', $processId)
            ->where('application_id', $applicationId)
            ->where('template_id', $templateId)
            ->first();
        $templateTableColumns = $this->getTemplateTableColumns($fieldValues, $templateId, $processId, $applicationId);
        if ($checkRow) {
            DB::table($templateTable)->update( $templateTableColumns);
        } else {
            DB::table($templateTable)->insert( $templateTableColumns);
        }
    }

    private function getTemplateTableColumns($fieldValues,$templateId, $processId, $applicationId )
    {
        $templateTableColumns = [];
        foreach($fieldValues as $key=>$value) {
            if ($value !== Null) {
                $templateTableColumns[$key] = $value;
            }
        }
        $templateTableColumns["template_id"] = $templateId;
        $templateTableColumns["process_id"] = $processId;
        $templateTableColumns["application_id"] = $applicationId;
        return $templateTableColumns;
    }

    private function getTemplateTableName($templateName)
    {
        $templateTable = $this->translateSybmols($templateName);
        $templateTable = $this->checkForWrongCharacters($templateTable);
        $templateTable = $this->modifyTemplateTable($templateTable);
        if (strlen($templateTable) > 57) {
            $templateTable = $this->truncateTableName($templateTable); // если количество символов больше 64, то необходимо укоротить длину названия до 64
        }
        return $templateTable;
    }

    private function getAllDictionariesWithOptions($dictionariesWithOptions)
    {
        $arrayToFront = [];
        foreach($dictionariesWithOptions as $item) {
            $replaced = str_replace(' ', '_', $item["name"]);
            $item["name"] = $replaced;
            array_push($arrayToFront, $item);
        }
        return $arrayToFront;
    }

}
