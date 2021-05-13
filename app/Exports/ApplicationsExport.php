<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use App\Process;
use App\Traits\dbQueries;
use App\Dictionary;

class ApplicationsExport implements FromArray, WithHeadings
{
	use dbQueries;
	private $headings = [];
	protected $request;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function array(): array
    {
    	$role_id = false;
    	$date_from = false;
    	$date_to = false;
    	$process_id = false;
    	$status_id = false;
    	if(isset($this->request['date_from'])){
        	$date_from = $this->request['date_from'];
        }
        if(isset($this->request['date_to'])){
      		$date_to = $this->request['date_to'];
      	}
      	if(isset($this->request['process'])){
      		$process_id = $this->request['process'];
      	}
      	if(isset($this->request['role_id'])){
      		$role_id = $this->request['role_id'];
      	}
      	if(isset($this->request['status_id'])){
      		$status_id = $this->request['status_id'];
      	}
	    $process = Process::where('id', $process_id)->first();
	    if($process_id == null){
	      return Redirect::back()->with('error', 'Выберите процесс и повторите попытку');
	    }

	    $tableName = $process->table_name;
	    $columns = $this->getColumns($tableName);
      $columns[] = $tableName.'.status_id';
	    $columns[] = $tableName.'.created_at';

	    $query = DB::table($tableName)
        ->select($columns);
      if($role_id){
        $query->join('process_role', 'process_role.process_id', '=', $tableName.'.process_id')
        ->where('process_role.role_id', '=', $role_id);
      }
	    if($date_from){
	    	$query->where($tableName.'.created_at', '>=', $date_from);
	    }
	    if($date_to){
	    	$query->where($tableName.'.created_at', '<=', $date_to);
	    }
	    if($status_id){
	    	$query->where('status_id', '=', $status_id);
	    }
	    $result = $query->get()->toArray();
      foreach ($result as $item) {
        switch ($item->status_id) {
          case 32:
            $item->status_id = 'ОТКЛОНЕННЫЙ';
            break;
          case 33:
            $item->status_id = 'СОГЛАСОВАННЫЙ';
            break;
          default:
            $item->status_id = 'В ПРОЦЕССЕ';
            break;
        }
      }
    	return $result;
    }

    public function headings(): array
    {
    	$process_id = $this->request['process'];
	    $process = Process::where('id', $process_id)->first();
    	$tableName = $process->table_name;
	    $columns = $this->getColumns($tableName);
	    $dics = Dictionary::all();
	    $headings = [];
	    foreach ($columns as $col) {
	    	foreach ($dics as $item) {
		    	if($item->name == $col){
            if($item->label_name != ''){
              $headings[] = $item->label_name;
            }else{
              $headings[] = $item->name;
            }
          }
		    }
	    }

      $headings[] = 'Статус';
	    $headings[] = 'Подана';
        return [$headings];
    }
}