<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;
use App\Process;
use App\Dictionary;
use DateTime;
use PDF;
use Response;
use App\Traits\dbQueries;

class UserController extends Controller
{
    use dbQueries;

    public function index()
    {
        $user = Auth::user();
        return view('user.index', compact('user'));
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make( $request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:10', 'min:10'],
        ]);
        if ($validator->fails()) {
            return Redirect::back()->with('status', 'Введите правильные данные');
        }
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->update();
        return Redirect::route('user.personalArea')->with('status', 'Данные успешно обновлены');
    }

    public function filter(Request $request){
      $requirement = $request->days;
      $allRequests = DB::table('logs')
                      ->join('created_tables', 'created_tables.id', '=', 'logs.table_id')
                      ->where('logs.role_id', '=', $request->id)
                      ->get()
                      ->toArray();
      $finish = date('Y-m-d H:i:s');
      //dd($allRequests);
      $result = array();
      foreach ($allRequests as $data) {
        $record = DB::table($data->name)
                    ->where($data->name.'.id', '=', $data->application_id)
                    ->first();

        $times = $this->getRecords($data->application_id, $data->table_id);

        $finish = date('Y-m-d H:i:s');
        $start = new DateTime($times[0]["created_at"]);
        $duration = $start->diff(new DateTime($finish));

        if($duration->days < $requirement){
          $process = Process::where('id', $record->process_id)->first();
          if(!isset($result[$process->name])){
              $result[$process->name] = array($record);
          }else{
              array_push($result[$process->name], $record);
          }

        }
      }
      // generation of PDF file and return
      $dictionaries = Dictionary::select('name', 'label_name')->where('input_type_id', '1')->get()->toArray();
      $dictionary = array();
      foreach ($dictionaries as $value) {
        $dictionary[$value['name']] = $value['label_name'];
      }
      
      $storagePathToPDF ='/app/public/final-docs/10.pdf';
      $pdf = PDF::loadView('filter', compact('requirement','result', 'dictionary')); // data send to PDF file
      $content = $pdf->output();
      file_put_contents(storage_path(). $storagePathToPDF, $content);
      $path = storage_path($storagePathToPDF);
      return Response::make(file_get_contents($path), 200, [
          'Content-Type' => 'application/pdf',
          'Content-Disposition' => 'inline; filename="10.pdf"'
      ]);

    }

}
