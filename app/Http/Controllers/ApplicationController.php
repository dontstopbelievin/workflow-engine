<?php

namespace App\Http\Controllers;

use App\Dictionary;
use App\EgknService;
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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Integrations\shep\sender\ShepRequestSender;
use Notification;
use App\TemplateDoc;
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
        $modalPopup = User::where('usertype', 'admin')->first()->has_not_accepted_agreement;

        return view('application.dashboard', compact('processes', 'modalPopup'));
    }

    public function index(Process $process) {
        $tableName = $process->table_name;
        $table = CreatedTable::where('name', $tableName)->first();
        if(!$table){
          return redirect()->back()->with('error', 'Услуга не существует.');
        }
        $arrayApps = $this->get_applications($tableName, $table->id);
        return view('application.index', compact('arrayApps', 'process'));
    }

    public function incoming(){
      $user = Auth::user();

      // get all processes where the user is engaged
      $allProcessesWithUser = $this->processesOfUser($user->role_id);
      $apps = [];
      // check if the user's id is in the "statuses" of every application of every process

      foreach ($allProcessesWithUser as $number => $process) {

        $tableName = $process->table_name;
        $allApplications = DB::table($tableName)
                        ->join('processes', 'processes.id', $tableName.'.process_id')
                        ->where($tableName.'.current_order', '=', $process->order)
                        ->whereJsonContains('statuses', $user->role_id)
                        ->where($tableName.'.current_order', '!=', '0')
                        ->where(function($q) use($tableName, $user){
                          if($user->region == null || $user->region == '') return;
                          $q->where($tableName.'.region', $user->region);
                        });

        $allApplications = $this->getFieldsForView($allApplications, $tableName);
        if(sizeof($allApplications) > 0){
          foreach($allApplications as $app){
            array_push($apps, $app);
          }
        }

      }
      return view('application.applications', compact('apps'));
    }

    public function outgoing(){
      $user = Auth::user();

      // get all processes where the user is engaged
      $allProcessesWithUser = $this->processesOfUser($user->role_id);
      $apps = [];
      // check if the user's id is NOT in the "statuses" of every application of every process
      foreach ($allProcessesWithUser as $number => $process) {
        $tableName = $process->table_name;
        $allApplications = DB::table($tableName)
                        ->join('processes', 'processes.id', $tableName.'.process_id')
                        ->where($tableName.'.current_order', '>=', $process->order)
                        ->whereJsonDoesntContain('statuses', $user->role_id)
                        ->where($tableName.'.current_order', '!=', '0');
        $allApplications = $this->getFieldsForView($allApplications, $tableName);
        if(sizeof($allApplications) > 0){
          foreach($allApplications as $app){
            array_push($apps, $app);
          }
        }
      }
      return view('application.applications', compact('apps'));
    }

    public function mydocs(){
        $user = Auth::user();
        // get all processes
        $allProcesses = Process::get();
        // check if the user's id is equal to 'user_id' for all processes
        $apps = [];
        foreach ($allProcesses as $number => $process) {
            $tableName = $process->table_name;
            $allApplications = DB::table($tableName)
                              ->join('processes', 'processes.id', $tableName.'.process_id')
                              ->where($tableName.'.user_id', '=', $user->id);
            $allApplications = $this->getFieldsForView($allApplications, $tableName);
            $apps = array_merge($apps, $allApplications->toArray());
        }
        return view('application.applications', compact('apps'));
    }

    public function drafts(){
      $apps = [];
      return view('application.applications', compact('apps'));
    }

    public function archive(){
        $user = Auth::user();
        // get all processes where the user is engaged
        $allProcessesWithUser = $this->processesOfUser($user->role_id);
        $apps = [];
        // check if the applications in each process the user engaged is finished
        foreach ($allProcessesWithUser as $number => $process) {
            $tableName = $process->table_name;
            $allApplications = DB::table($tableName)
                              ->join('processes', 'processes.id', $tableName.'.process_id')
                              ->where($tableName.'.current_order', '=', '0');
            $allApplications = $this->getFieldsForView($allApplications, $tableName);
            $apps = array_merge($apps, $allApplications->toArray());
        }
        return view('application.applications', compact('apps'));
    }

    public function processesOfUser($role_id){
      return DB::table('process_role')
                ->join('processes', 'processes.id', '=', 'process_role.process_id')
                ->where('role_id', $role_id)
                ->distinct()
                ->get();
    }

    private function getFieldsForView($allApplications, $tableName){
      if (Schema::hasTable($tableName)) {
        return $allApplications->select('processes.id as process_id', 'processes.name as process_name', $tableName.'.current_order', $tableName.'.statuses',  $tableName.'.id as application_id', $tableName.'.created_at',
          'users.first_name', 'users.sur_name', 'users.middle_name', $tableName.'.deadline_date')
          ->join('users', $tableName.'.user_id', '=', 'users.id')->get();
        //  $tableName.'.first_name',  $tableName.'.surname',
      }else{
        return collect();//return empty collection
      }
    }

    public function view($processId, $applicationId)
    {
        $process = Process::find($processId);
        $table = CreatedTable::where('name', $process->table_name)->first();
        $application = DB::table($process->table_name)->where('id', $applicationId)->first();

        $canApprove = false;

        foreach(json_decode($application->statuses) as $id) {

            if ($id === Auth::user()->role_id) {
                $canApprove = true;
                break;
            }
        }

        $records = $this->getRecords($application->id, $table->id, $application->region);
        $toCitizen = false;

        if(Auth::user()->role_id != 1){
            // начало проверки на последнего специалиста в процессе
            if(!$process->roles()->select('order')->where('role_id', Auth::user()->role_id)->first()){
                return Redirect::back()->with('error', 'Вы не состоите в процессе.');
            }
            $children = $process->roles()->where('parent_role_id', Auth::user()->role_id)->get();
            $maxOrder = $process->roles()->max('order');
            $currentRoles = $this->getProcessStatuses($process->table_name, $application->id);
            if (sizeof($currentRoles) == 1 && sizeof($children)==0 && $maxOrder == $application->current_order) {
                $toCitizen = true; // если заявку подписывает последний специалист в обороте, заявка идет обратно к заявителю
            }
        }

        $tableColumns = $this->getColumns($process->table_name);
        $aRowNameRows = $this->getAllDictionaries(array_values($tableColumns));

        $template = Template::where('role_id', Auth::user()->role_id)->where('order', $application->current_order)->first();
        $templateFields = [];
        if($template){
            $templateFields = TemplateField::where('template_id', $template->id)->get();
            $templateFields = $this->get_field_options($templateFields);

        }

        $templateTableFields = $this->get_templates($process->id, $application->id);
        $buttons = DB::table('process_role')
                  ->where('process_id', $process->id)
                  ->where('role_id', Auth::user()->role_id)
                  ->where('order', $application->current_order)
                  ->get()
                  ->toArray();

        if(isset($buttons[0]) && $application->reject_reason != null){
          $buttons[0]->can_reject = 0;
        }

        $rolesToRevision = [];
        if(isset($buttons[0]) && $buttons[0]->can_send_to_revision == 1){
            $rolesToRevision = $this->get_roles_before($process, $application->current_order, Auth::user()->role_id);
        }

        $rolesToSelect = [];
        if(isset($buttons[0])){
            $rolesToSelect = $this->get_roles_for_select($process, $application->current_order, Auth::user()->role_id);
        }

        $application_arr = json_decode(json_encode($application), true);

        return view('application.view', compact('application','templateTableFields','templateFields', 'process','canApprove', 'toCitizen', 'rolesToRevision', 'records', 'buttons', 'aRowNameRows','application_arr', 'rolesToSelect'));
    }

    public function getXML(Request $request){
      $process = Process::find($request->processId);
      $tableName = $process->table_name;
      $application = DB::table($tableName)->where('id', $request->applicationId)->first();

      $aApplicationRows = $this->getRowsForEcp($tableName, $request->processId, $request->applicationId, $application->current_order);
      $aApplicationXmlRows = $this->xmlGenerator($aApplicationRows);

      return $aApplicationXmlRows;
    }

    public function getRowsForEcp($tableName, $processId, $applicationId, $current_order){
        $application = DB::table($tableName)->select($this->getColumns($tableName))->where('id', $applicationId)->first();
        $application->application_id = $applicationId;
        $application->process_id = $processId;
        $application->role_id = Auth::user()->role_id;
        $application->templates = [];
        // get templates
        $templates = Template::where('process_id', $processId)->get();
        // $templates = Template::where('process_id', $processId)->where('order', '<=', $current_order)->get();

        foreach ($templates as $key => $template) {
            $template_table = $template->table_name;
            $docs = DB::table($template_table)->get()->toArray();
            $application->templates[$template_table] = $docs;
        }

        return json_decode(json_encode($application), true);
    }

    public function acceptAgreement(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'accepted' => ['required'],
        ]);
        if ($validator->fails()) {
          return response()->json(['message' => false], 400);
        }
        if ($request->accepted == 'true') {
            $user = Auth::user();
            $user->has_not_accepted_agreement = false;
            $user->update();
            return response()->json(['message' => true], 200);
        }
        return response()->json(['message' => false], 200);
    }

    public function approveReject(Request $request){
      $validator = Validator::make($request->all(),[
          'application_id' => ['required'],
          'process_id' => ['required'],
      ]);
      if ($validator->fails()) {
        return Response::json(array(
            'error' => $validator->getMessageBag()->toArray()
        ), 400);
      }
      try {
          DB::beginTransaction();
          $process = Process::find($request->process_id);
          $tableName = $process->table_name;
          $application = DB::table($tableName)->where('id', $request->application_id)->first();
          $table = CreatedTable::where('name', $tableName)->first();

          $user = Auth::user();

          $currentRoleOrder = $application->current_order;

          $this->insertLogs($user->role->name, 2, $table->id, $application->id, $user->role_id, $currentRoleOrder, 0, '', "Согласовал(а) отказ");

          if($request->roleToSelect){
            $nextRoleId = [(int)$request->roleToSelect, $currentRoleOrder];
          }else{
            $nextRoleId = $this->getNextUnparallelRoleId($process, $currentRoleOrder, $request->application_id,  $table->id);
          }

          if($nextRoleId[0] == 1){
            DB::table($tableName)
                ->where('id', $request->application_id)
                ->update(['status_id' => 32, 'statuses' => '[]', 'current_order' => 0]);
          }else{
            DB::table($tableName)
                ->where('id', $request->application_id)
                ->update(['statuses' => [$nextRoleId[0]], 'current_order' => $nextRoleId[1]]);
          }
          DB::commit();
      }catch (Exception $e) {
          DB::rollBack();
          return Redirect::to('docs')->with('status', $e->getMessage());
      }
    }

    public function approve(Request $request) {
      $validator = Validator::make($request->all(),[
          'application_id' => ['required'],
          'process_id' => ['required'],
          'comments' => ['required', 'min:3'],
      ]);
      if ($validator->fails()) {
        return Response::json(array(
            'error' => $validator->getMessageBag()->toArray()
        ), 400);
      }
        try {
            DB::beginTransaction();
            $fieldValues = $request->all();
            if ($fieldValues) {
                foreach($fieldValues as $key=>$val) {
                    if (is_file($val)) {
                        $path = $request->file($key)->store('application-docs','public');
                        $fieldValues[$key] = $path;
                    }
                    if ($key === 'id' || $key === 'application_id' || $key === '_token' || $key === 'pdf_url'
                    || $key == 'process_id' || $key == 'comments' || $key == 'roleToSelect') {
                      unset($fieldValues[$key]);
                    }
                }
            }

            foreach ($fieldValues as $key => $value) {
                $dictionary = Dictionary::where('name', $key)->first();
                if(isset($dictionary) && $dictionary->required == 1){
                  $validator = Validator::make($request->input(),[
                      $key => 'required|not_in:null',
                  ]);
                  if ($validator->fails()) {
                    return Response::json(array(
                        'error' => $validator->getMessageBag()->toArray()
                    ), 400);
                  }
                }
            }

            $process = Process::find($request->process_id);
            $tableName = $process->table_name;
            $table = CreatedTable::where('name', $tableName)->first();
            $application = DB::table($tableName)->where('id', $request->application_id)->first();
            $template = Template::where('role_id', Auth::user()->role_id)->where('order', $application->current_order)->where('process_id', $process->id)->first();
            $comment = $request->comments;

            $pathToView = 'PDFtemplates.empty';//to skip template doc creation if non template exist
            if($template){
              // insertion of fields into template
              if(!$this->insertTemplateFields($fieldValues, $request->application_id, $template)){
                  DB::rollBack();
                  return Redirect::to('docs')->with('error', 'insert template fields error');
              }
              $template_doc = TemplateDoc::find($template->template_doc_id);
              $pathToView = $template_doc->pdf_path;
            }

            if($pathToView != 'PDFtemplates.empty'){
              $fields = DB::table($template->table_name)->select('*')->where('application_id', $application->id)->first();
              $aFields = json_decode(json_encode($fields), true);

              $updatedFields = [];
              if ($aFields !== Null) {
                foreach($aFields as $key => $field) {
                    if ($key === 'id' || $key === 'application_id' || $key === '_token' || $key === 'pdf_url') {
                        continue;
                    }
                    $updatedFields[$key] = $field;
                }
              }

              $QR_text = $_SERVER['HTTP_HOST'] . "/verification/" . $process->id . "/" . $application->id . "/" . $template->id;

              $fileName = $this->generateRandomString();
              $applicant = User::where('id', $application->user_id)->first();
              $updatedFields["date"] = date('d-m-Y');
              $updatedFields["id"] = $application->id;
              $updatedFields["applicant_name"] = $applicant->sur_name.' '.$applicant->first_name.' '.$applicant->middle_name;
              $updatedFields = $this->add_app_columns($updatedFields, $tableName, $application->id);
              $updatedFields = $this->get_test_values($updatedFields);

              $userName = Auth::user()->sur_name.' '.Auth::user()->first_name.' '.Auth::user()->middle_name;
              $roleName = Auth::user()->role->name;
              $storagePathToPDF ='/app/public/final_docs/' . $fileName . '.pdf';
              $content = view($pathToView, compact('updatedFields', 'userName', 'roleName', 'QR_text'))->render();
              $mpdf = new Mpdf();
              $mpdf->WriteHTML($content);
              $mpdf->Output(storage_path(). $storagePathToPDF, \Mpdf\Output\Destination::FILE);
              $docPath = 'final_docs/'. $fileName . '.pdf';
              DB::table($template->table_name)->where('application_id', $request->application_id)
                ->update(['pdf_url' => $docPath]);
            }

            $currentRoleOrder = $application->current_order;
            $processRoles = $this->getProcessStatuses($tableName, $request->application_id);
            $children = $this->getRoleChildren($process);
            $this->insertLogs(Auth::user()->role->name, 1, $table->id, $request->application_id, Auth::user()->role_id, $currentRoleOrder, 1, '',$comment);

            $processRoles = array_values($this->deleteCurrentRoleAddChildren($process, $processRoles, $children, $currentRoleOrder, $table->id, $request->application_id, 1, $tableName));

            //PROVERKA KOMM SLUZHB

            //proverka na select
            if($request->roleToSelect){
              $processRoles = $this->remove_unselected($processRoles, $request->roleToSelect, $process, $currentRoleOrder, Auth::user()->role_id);
            }

            if(sizeof($processRoles) == 0){
              DB::table($tableName)
                ->where('id', $request->application_id)
                ->update(['status_id' => 33, 'statuses' => '[]', 'current_order' => 0]);
            }else{
              DB::table($tableName)
                  ->where('id', $request->application_id)
                  ->update(['statuses' => $processRoles]);
            }
            DB::commit();
            return response()->json(['success' => 'true'], 200);
        }catch (Exception $e) {
            DB::rollBack();
            return Redirect::to('docs')->with('status', $e->getMessage());
        }
    }

    public function deleteCurrentRoleAddChildren($process, $processRoles, $children, $currentRoleOrder, $table_id, $appl_id, $answer, $tableName){
      $response = array();
      if(sizeof($children) > 0){
        $children = array_column($children, 'role_id');
        $proceededChildren = $this->checkArrayOfServicesOrRoles($children, $process, $currentRoleOrder, $table_id, $appl_id); // add arguments if needed
        if(sizeof($processRoles) == 1 && sizeof($proceededChildren) == 0){ // when it is last user which have only services as children
          return $this->deleteCurrentRoleAddChildren($process, $processRoles, [], $currentRoleOrder, $table_id, $appl_id, $answer, $tableName);
        }else if(sizeof($processRoles) == 1){ // when it is last user but have other roles as children
          $processRoles = $proceededChildren;
        }else{
          if(sizeof($proceededChildren) != 0){ // when there are other roles on parallel
            foreach($proceededChildren as $child){
              array_push($processRoles, $child);
            }
          }
          $processRoles = $this->deleteCurrentRoleFromStatuses($processRoles);
        }
      }else{
        if(sizeof($processRoles) != 1){ // if NOT last one in array => just delete it from $processRoles (it does not have children)
          $processRoles = $this->deleteCurrentRoleFromStatuses($processRoles);
          $orderAfterDeleting = $currentRoleOrder;
        }else{   // if the last one in array
          while(1){ // stop when next roles are obtained(without sync services)
            $processRoles = $this->get_roles_of_order($process->id, $currentRoleOrder+1)->toArray(); // find next roles
            if(sizeof($processRoles) == 0){ // if maximum order is reached
              return [];
              break;
            }else{
              $proceededRoles = $this->checkArrayOfServicesOrRoles($processRoles, $process, $currentRoleOrder+1, $table_id, $appl_id);
              if(sizeof($proceededRoles) == 0){ // if all after are services
                $currentRoleOrder++;
                continue;
              }else{ // if roles are after => return them
                $processRoles = $proceededRoles;
                $orderAfterDeleting = $currentRoleOrder+1;
                break;
              }
            }
          }
          DB::table($tableName)
              ->where('id', $appl_id)
              ->update(['current_order' => $currentRoleOrder+1]);
        }
      }

      return $processRoles;
    }

    public function checkArrayOfServicesOrRoles($servicesOrRoles, $process, $currentRoleOrder, $table_id, $appl_id){
      $resultingRoles = [];
      for ($key = 0; $key < sizeof($servicesOrRoles); $key++) {
        $id = $servicesOrRoles[$key];
        $role = Role::where('id', $id)->first();
        if($role->isRole == 0 && $role->service_sync == 1){
          // execute service
          $this->insertLogs($role->name, 1, $table_id, $appl_id, $id, $currentRoleOrder, '');
          $children = $process->roles()->where('parent_role_id', $id)->select('role_id')->get();//currentRoleOrder
          if(sizeof($children) != 0){
            foreach($children as $child){
              array_push($servicesOrRoles, $child->role_id);
            }
          }
        }else{
          array_push($resultingRoles, $id);
          $this->insertLogs($role->name, 4, $table_id, $appl_id, Auth::user()->role_id, $currentRoleOrder, '');
        }
      }
      return $resultingRoles;
    }

    public function create(Process $process)
    {
        $tableName = $process->table_name;
        $tableColumns = $this->getColumns($tableName);
        $dictionaries = $this->get_dic_in_order($tableColumns);
        $arrayToFront = $this->addOptionsToDictionary($dictionaries);
        $roles = $this->get_roles_in_order($process->id);
        if(count($roles) == 0){
            return Redirect::action([ApplicationController::class, 'service'])->with('status', 'Создайте сперва маршрут!');
        }
        return view('application.create', compact('process', 'arrayToFront'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->input();
            // return response()->json(['data'=>$input], 200);
            if ($request->hasFile('attachment')) {
                $input["attachment"] = $request->file('attachment')->store('applicant-attachments','public');
            }
            $applicationTableFields = $input;
            if(isset($applicationTableFields['_token'])){
                unset($applicationTableFields['_token']);
            }
            $process = Process::find($request->process_id);

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

            $tableName = $process->table_name;
            $table = CreatedTable::where('name', $tableName)->first();
            $applicationTableFields["statuses"] = $this->get_roles_of_order($process->id, 1);
            $applicationTableFields["current_order"] = 1;
            $applicationTableFields["status_id"] = 0;
            $applicationTableFields["user_id"] = Auth::user()->id;
            $applicationTableFields["deadline_date"] = $this->holiday_diff_in_date($process->deadline);
            // return response()->json(['error' => $applicationTableFields], 500);
            foreach ($applicationTableFields as $key => $value) {
                $dictionary = Dictionary::where('name', $key)->first();
                if(isset($dictionary) && $dictionary->required == 1){
                  $validator = Validator::make($request->input(),[
                      $key => 'required|not_in:null',
                  ]);
                  //dd($validator);
                  if ($validator->fails()) {
                    return Response::json(array(
                        'error' => $validator->getMessageBag()->toArray()
                    ), 400);
                  }
                }
            }
            $application_id = DB::table($tableName)->insertGetId($applicationTableFields);

            foreach ($applicationTableFields["statuses"] as $value) {
                $role = Role::select('name')->where('id', $value)->first();
                $this->insertLogs($role->name, 4, $table->id, $application_id, Auth::user()->role_id, 0, 1);
            }
            DB::commit();
            return response()->json(['proc_id' => $process->id, 'app_id' => $application_id, 'deadline' => $process->deadline], 200);
            // return Redirect::to('docs')->with('status', 'Заявка Успешно создана');
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function getFirstRoles($routesArr) {
        $firstRolesArr = [];
        foreach($routesArr as $route) {
            $firstRole = array_shift($route);
            array_push($firstRolesArr, $firstRole);
        }
        return $firstRolesArr;
    }

    private function getStatuses($routes) {
        $statuses = [];
        foreach($routes as $route) {
            array_push($statuses, $route["role_id"]);
        }
        return $statuses;
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
        $validator = Validator::make($request->all(),[
            'processId' => ['required'],
        ]);
        if ($validator->fails()) {
          return Response::json(array(
              'error' => $validator->getMessageBag()->toArray()
          ), 400);
        }

        $process = Process::find($request->processId);
        $routes = $this->getRolesWithoutParent($process->id);
        $arrRoutes = json_decode($routes, true);
        $status = Status::find($arrRoutes[0]["id"]);
        $tableName = $process->table_name;
        $table = CreatedTable::where('name', $tableName)->first();
        $user = Auth::user();

        // $aData = ["coordindates" => "5645226",   "goal" => "123213213", "area" => "34123453", "processId" => $process->id];
        // $applicationTableFields["coordindates"] = $aData["coordindates"];
        // $applicationTableFields["goal"] = $aData["goal"];
        // $applicationTableFields["area"] = $aData["area"];
        // $modifiedApplicationTableFields = $this->modifyApplicationTableFields($applicationTableFields, $status->id, $user->id);
        // $applicationId = DB::table($tableName)->insertGetId( $modifiedApplicationTableFields);
        // $logsArray = $this->getFirstLogs($status->id, $table->id, $applicationId, $arrRoutes[0]["id"]); // получить историю хода согласования

        $incomingApplications = EgknService::where('passed_to_process', 0)->get();
        if (!count($incomingApplications)) {
            return Redirect::to('docs')->with('status', 'Новых заявок не обнаружено');
        }
        $countApp = 0; // считаем количество заявок
        foreach($incomingApplications as $app) {
            $countApp++;
            $applicationTableFields = [];
            $applicationTableFields["process_id"] = $process->id;
            $app->passed_to_process = 1;
            $app->timestamps = false;
            $app->update();
            $attrOfIncApp = $app->getAttributes();
            array_shift($attrOfIncApp);
            foreach ($attrOfIncApp as $key => $value) {
                $applicationTableFields[$key] = $value;
            };
            $modifiedApplicationTableFields = $this->modifyApplicationTableFieldsWithStatus($applicationTableFields, $status->id, $user->id);
            $applicationId = DB::table($tableName)->insertGetId( $modifiedApplicationTableFields);
            // $this->insertLogs($status->id, $table->id, $applicationId, $role->id);
        }

        return Redirect::to('docs')->with('status', 'Заявки Успешно созданы (' . $countApp . ')');
    }

    public function toCitizen(Request $request)
    {
      $validator = Validator::make($request->all(),[
          'application_id' => ['required'],
          'process_id' => ['required'],
          'comments' => ['required', 'min:3'],
          'answer' => ['required']
      ]);
      if ($validator->fails()) {
        return Response::json(array(
            'error' => $validator->getMessageBag()->toArray()
        ), 400);
      }
      try {
          DB::beginTransaction();
          $role = Auth::user()->role;
          $applicationId = $request->application_id;
          $process = Process::find($request->process_id);
          $tableName = $process->table_name;
          $table = CreatedTable::where('name', $tableName)->first();
          $approveOrReject = $request->answer;
          $comment = (isset($request->comments)) ? $request->comments : "";
          $user = Auth::user();
          $application = DB::table($tableName)->where('id', $request->application_id)->first();
          $currentRoleOrder = $application->current_order;

          $this->insertLogs($user->role->name, ($approveOrReject == 0) ? 2 : 1, $table->id, $applicationId, $user->role_id, $currentRoleOrder, $approveOrReject,'', $comment);
          $this->insertLogs('Заявитель', 4, $table->id, $applicationId, $user->role_id, $currentRoleOrder, $approveOrReject,'');

          // updating the status_id (not the statuses field) as "Sent to citizen"
          $statusId = ($approveOrReject == 0) ? 32 : 33;
          $status = Status::find($statusId);
          $affected = DB::table($tableName)
              ->where('id', $applicationId)
              ->update(['status_id' => $statusId, 'current_order' => 0, 'statuses' => '[]']);

          DB::commit();
          return Redirect::to('docs')->with('status', $status->name);
      } catch (Exception $e) {
          DB::rollBack();
          return response()->json(['message' => $e->getMessage()], 500);
      }
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
      $validator = Validator::make($request->all(),[
          'application_id' => ['required'],
          'process_id' => ['required'],
          'rejectReason' => ['required', 'min:3'],
      ]);
      if ($validator->fails()) {
        return Response::json(array(
            'error' => $validator->getMessageBag()->toArray()
        ), 400);
      }
        try {
            DB::beginTransaction();
            $process = Process::find($request->process_id);
            $tableName = $process->table_name;
            $application = DB::table($tableName)->where('id', $request->application_id)->first();
            $table = CreatedTable::where('name', $tableName)->first();

            $user = Auth::user();
            $currentRoleOrder = $application->current_order;

            $this->insertLogs(Auth::user()->role->name, 2, $table->id, $application->id, $user->role_id, $currentRoleOrder, 0, '', $request->rejectReason);

            if($request->motiv_otkaz == 1){ // если у него мотивированный отказ есть => reject_reason заполнить, и дальше чисто согласование мотив отказа
                if($request->roleToSelect){
                  $nextRoleId = [(int)$request->roleToSelect, $currentRoleOrder];
                }else{
                  $nextRoleId = $this->getNextUnparallelRoleId($process, $currentRoleOrder, $request->application_id,  $table->id);
                }
                if($nextRoleId[0] == 1){
                  DB::table($tableName)
                      ->where('id', $request->application_id)
                      ->update(['status_id' => 32, 'statuses' => '[]', 'reject_reason' => $request->rejectReason, 'reject_reason_from_spec_id' => $user->role_id, 'current_order' => 0]);
                }else{
                  DB::table($tableName)
                      ->where('id', $request->application_id)
                      ->update(['statuses' => [$nextRoleId[0]], 'reject_reason' => $request->rejectReason, 'current_order' => $nextRoleId[1], 'reject_reason_from_spec_id' => $user->role_id]);
                }
            }else{
                $processRoles = $this->getProcessStatuses($tableName, $request->application_id);
                $children = $this->getRoleChildren($process);
                $processRoles = array_values($this->deleteCurrentRoleAddChildren($process, $processRoles, $children, $currentRoleOrder, $table->id, $request->application_id, 0, $tableName));

                //proverka na select
                if($request->roleToSelect){
                  $processRoles = $this->remove_unselected($processRoles, $request->roleToSelect, $process, $currentRoleOrder, Auth::user()->role_id);
                }

                if(sizeof($processRoles) == 0){
                  DB::table($tableName)
                      ->where('id', $request->application_id)
                      ->update(['status_id' => 32, 'statuses' => '[]', 'current_order' => 0]);
                }else{
                  DB::table($tableName)
                      ->where('id', $request->application_id)
                      ->update(['statuses' => $processRoles]);
                }
            }

            DB::commit();
            return response()->json(['message' => 'success'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function revision(Request $request)
    {
      $validator = Validator::make($request->all(),[
          'application_id' => ['required'],
          'processId' => ['required'],
          'revisionReason' => ['required', 'min:3'],
          'roleToRevise' => ['required']
      ]);
      if ($validator->fails()) {
        return Response::json(array(
            'error' => $validator->getMessageBag()->toArray()
        ), 400);
      }
      try {
          DB::beginTransaction();
          $roleToRevise = $request->roleToRevise; //Роль, которому форма отправляется на доработку
          $process = Process::find($request->processId);
          $tableName = $process->table_name;
          $user = Auth::user();
          $to_role = Role::where('name', $roleToRevise)->first();
          $table = CreatedTable::where('name', $tableName)->first();
          $application = DB::table($tableName)->where('id', $request->application_id)->first();

          $currentRoleOrder = $application->current_order;
          $sendingRoleOrder = $process->roles()->select('order')->where('role_id', $to_role->id)->first()->order;

          if($currentRoleOrder == $sendingRoleOrder){
            $processRoles = $this->getProcessStatuses($tableName, $request->application_id);
            $processRoles = array_values($this->deleteCurrentRoleFromStatuses($processRoles));
            array_push($processRoles, $to_role->id);

            DB::table($tableName)
                    ->where('id', $request->application_id)
                    ->update(['statuses' => $processRoles, 'current_order' => $sendingRoleOrder, 'revision_reason' => $request->revisionReason, 'revision_reason_from_spec_id' =>  $user->role_id, 'revision_reason_to_spec_id' => $to_role->id]);
          }else{
            DB::table($tableName)
                    ->where('id', $request->application_id)
                    ->update(['statuses' => [$to_role->id], 'current_order' => $sendingRoleOrder, 'revision_reason' => $request->revisionReason, 'revision_reason_from_spec_id' =>  $user->role_id, 'revision_reason_to_spec_id' => $to_role->id]);
          }

          $this->insertLogs($roleToRevise, 4, $table->id, $application->id, $user->role_id, $currentRoleOrder, 2, $roleToRevise, $request->revisionReason);


        DB::commit();
        return response()->json(['message' => 'success'], 200);
      } catch (Exception $e) {
        DB::rollBack();
        return response()->json(['message' => $e->getMessage()], 500);
      }
    }

    private function getSeveralStatuses($process, $table) {
        $statuses = [];
        array_push($statuses, $process->status);
        array_push($statuses, $table->status);

        return $statuses;
    }

    private function getRoleAfterParallel($process)
    {
        $roleWithIndex = [];
        $role = Auth::user();
        $children = $process->roles()->where('parent_role_id', $role->role_id)->get()->toArray();

        if(sizeof($children) != 0){
            $roleWithIndex['children'] = $children;
        }else{

            $order = $process->roles()->select('order', 'parent_role_id')->where('role_id', $role->role_id)->first()->toArray();
            $parallelRoles = $process->roles()->where('order', $order['order'])->get()->toArray();

            //$isParallel = sizeof($parallelRoles) != 0;

            $roleWithIndex['parallelAfter'] = $process->roles()->where('order', $order['order'] + 1)->count();
            $roleWithIndex['order'] = $order['order']+1;
            $roleWithIndex['roleAfterParallel'] = $process->roles()->where('order', $order['order'] + 1)->get()->toArray();
        }

        // foreach($parallelRoles as $role) {
        //     $index++;
        //     if ($isParallel && $role["pivot"]["is_parallel"] === 0) {
        //         $roleWithIndex["roleAfterParallel"] = $role;
        //         break;
        //     }
        //     if ($role["pivot"]["is_parallel"] !== 0) {
        //         $isParallel = true;
        //     }
        // }
        return $roleWithIndex;
    }

    private function insertLogs($role_name, $status_n, $table_id, $application_id, $role_id, $order, $answer, $to_role = '', $comment = '')
    {
      $role_status = DB::table('role_statuses')->where('role_name', $role_name)->where('status_id', $status_n)->first();
      $logsArray = [];
      $logsArray["status_id"] = $role_status->id;
      $logsArray["table_id"] = $table_id;
      $logsArray["application_id"] = $application_id;
      $logsArray["role_id"] = $role_id;
      $logsArray["order"] = $order;
      $logsArray["answer"] = $answer;
      $logsArray["comment"] = $comment;
      $logsArray["to_role"] = $to_role;
      $logsArray["created_at"] = Carbon::now();
      if(Log::insert($logsArray)){
          return true;
      }
      return false;
    }

     private function insertTemplateFields($fieldValues, $applicationId, $template)
    {
        try {
            DB::beginTransaction();
            $checkRow = DB::table($template->table_name)
                ->where('application_id', $applicationId)
                ->first();
            $templateTableColumns = $this->getTemplateTableColumns($fieldValues, $applicationId);
            if ($checkRow) {
                DB::table($template->table_name)->update( $templateTableColumns);
            } else {
                DB::table($template->table_name)->insert( $templateTableColumns);
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function get_test_values($updatedFields)
    {
      // $updatedFields["applicant_address"] = 'asdf';
        // $updatedFields["applicant_name"] = 'Аман';
        // $updatedFields["area"] = '114 га';
        // $updatedFields["area2"] = '114 га';
        // $updatedFields["flat_number"] = '114 га';
        // $updatedFields["square"] = 'Байконур';
        // $updatedFields["street"] = 'Кабанбай батыра';
        // $updatedFields["duration"] = '12';
        // $updatedFields["object_name"] = 'object_name';
        // $updatedFields["cadastral_number"] = '1146';
        // $updatedFields["construction_name_before"] = '1146';
        // $updatedFields["construction_name_after"] = '1146';
        // $updatedFields["area_number"] = '1146';
        // $updatedFields["construction_name_before"] = 'Строительство';
        // $updatedFields["construction_name_after"] = 'Делопроизводство';
        // $updatedFields["area_number"] = '1146';
        return $updatedFields;
    }

    private function getTemplateTableColumns($fieldValues, $applicationId )
    {
        $templateTableColumns = [];
        foreach($fieldValues as $key=>$value) {
            if ($value !== Null) {
                $templateTableColumns[$key] = $value;
            }
        }
        $templateTableColumns["application_id"] = $applicationId;
        return $templateTableColumns;
    }

    public function verification($p, $a, $t){
        try {
            if(!isset($t) && !isset($a) && !isset($p)){
                throw new Exception('Ошибка даных QrCode.');
            }
            $template = Template::select('templates.id', 'templates.table_name', 'template_docs.name')
            ->join('template_docs', 'templates.template_doc_id', '=', 'template_docs.id')
            ->where('process_id', $t)->first();

            if(!$template){
                throw new \Exception('Ошибка проверки QrCode.');
            }
            $process = Process::find($p);
            if(!$process){
                throw new \Exception('Ошибка проверки QrCode.');
            }
            $application = DB::table($process->table_name)->where('id', $a)->first();
            if(!$application){
                throw new \Exception('Ошибка проверки QrCode.');
            }

            $tableColumns = $this->getColumns($process->table_name);
            $aRowNameRows = $this->getAllDictionaries(array_values($tableColumns));
            $user = User::find($application->user_id);
            $application_arr = json_decode(json_encode($application), true);

            $templateFields = new \stdClass();
            $templateFields->id = $template->id;
            $templateFields->name = $template->name;
            $fields = DB::table($template->table_name)->where('application_id', $application->id)->first();
            if($fields){
                $fields = json_decode(json_encode($fields), true);
                $exceptionArray = ["id", "application_id"];
                $templateFields->fields = $this->filterTemplateFieldsTable($fields, $exceptionArray);
                $templateFields->fields = $this->get_field_label($templateFields->fields, $templateFields->id);
            }else{
                $templateFields->fields = [];
            }
            $done = true;
            return view('application.verification', compact('templateFields', 'application_arr', 'process', 'tableColumns', 'aRowNameRows', 'user', 'done'));
        } catch (\Exception $e) {
            return view('application.verification')->with('error', $e->getMessage());
        }
    }
}
