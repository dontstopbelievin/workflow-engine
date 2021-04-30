<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;
use App\Log;
use App\Process;
use App\Dictionary;
use App\CreatedTable;
use DateTime;
use PDF;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use Response;
use App\Traits\dbQueries;

class UserController extends Controller
{
    use dbQueries;

    public function index()
    {
        $user = Auth::user();
        $processes = DB::table('process_role')->join('processes', 'processes.id', '=', 'process_role.process_id')
                                              ->select('process_id', 'name')
                                              ->where('role_id', $user->role_id)
                                              ->get()->toArray();
        return view('user.index', compact('user', 'processes'));
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make( $request->all(),[
            'sur_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:10', 'min:10'],
        ]);
        if ($validator->fails()) {
            return Redirect::back()->with('status', 'Введите правильные данные');
        }
        $user->sur_name = $request->sur_name;
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->phone = $request->phone;
        $user->update();
        return Redirect::to('user/personal_area')->with('status', 'Данные успешно обновлены');
    }

    public function deleteUnnecessary($result, $delete) {
      foreach ($result as $key => $process) {
        if(isset($process->attachment)){
          unset($process->attachment);
        }
        foreach ($delete as $column) {
          unset($process->$column);
        }
      }
      return $result;
    }

    public function filter(Request $request){
      $requirement = $request->days;
      $process_id = $request->process;
      if($process_id == null){
        return Redirect::back()->with('error', 'Выберите процесс и повторите попытку');
      }

      $user = Auth::user();
      $tableName = $process->table_name;

      $tableId = CreatedTable::select('id')->where('name', $tableName)->first()->toArray();

      $allRequests = DB::table($tableName)
                        ->select($tableName.'.*', 'statuses.name as status', 'logs.created_at')
                        ->join('logs', 'logs.application_id', '=', $tableName.'.id')
                        ->where('logs.role_id', '1')->where('logs.table_id', $tableId['id'])
                        ->join('statuses', 'statuses.id', '=', $tableName.'.status_id')
                        ->where($tableName.'.name', '!=', 'NULL')->get()->toArray();

      $finish = date('Y-m-d H:i:s');
      //dd($allRequests);
      $result = array();
      foreach ($allRequests as $record) {
        //dd($record);
        $finish = date('Y-m-d H:i:s');
        $start = new DateTime($record->updated_at);
        $duration = $start->diff(new DateTime($finish));

        if($duration->days < $requirement){
          if(!isset($result[$process_id])){
              $result[$process_id] = array($record);
          }else{
              array_push($result[$process_id], $record);
          }
        }
      }
      // generation of PDF file and return
      $dictionaries = Dictionary::select('dictionaries.name', 'dictionaries.label_name')
                      ->join('input_types', 'dictionaries.input_type_id', '=', 'input_types.id')
                      ->where('input_types.name', '!=','file')
                      ->get()->toArray();
      $dictionary = array();
      foreach ($dictionaries as $value) {
        $dictionary[$value['name']] = $value['label_name'];
      }
      $result[$process_id] = $this->deleteUnnecessary($result[$process_id], ['process_id', 'status_id', 'user_id', 'index_main', 'reject_reason', 'reject_reason_from_spec_id', 'to_revision', 'revision_reason', 'revision_reason_from_spec_id', 'revision_reason_to_spec_id', 'updated_at']);

      $storagePathToPDF ='/app/public/final_docs/10.pdf';
      $content = view('filter', compact('requirement','result', 'dictionary'))->render();
      $mpdf = new Mpdf();
      $mpdf->WriteHTML($content);
      $mpdf->Output(storage_path(). $storagePathToPDF, \Mpdf\Output\Destination::FILE);

      $path = storage_path($storagePathToPDF);
      return Response::make(file_get_contents($path), 200, [
          'Content-Type' => 'application/pdf',
          'Content-Disposition' => 'inline; filename="10.pdf"'
      ]);

    }



}
