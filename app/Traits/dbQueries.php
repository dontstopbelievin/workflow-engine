<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Dictionary;
use App\Log;
use App\Role;
use App\Status;
use App\Template;
use App\TemplateField;
use App\HolidayCalendar;

trait dbQueries
{

    public function get_roles_of_order($process_id, $order){

        return DB::table('roles')
            ->join('process_role', 'roles.id','=','process_role.role_id')
            ->select('roles.id')
            ->where('process_role.process_id', $process_id)
            ->where('process_role.parent_role_id', NULL)
            ->where('process_role.order', $order)
            ->orderBy('process_role.order', 'asc')
            ->get()->pluck('id');
    }

    public function get_roles_in_order($process_id){

        return DB::table('roles')
            ->join('process_role', 'roles.id','=','process_role.role_id')
            ->select('process_role.id', 'roles.id as role_id', 'roles.name','process_role.order')
            ->where('process_role.process_id', $process_id)
            ->orderBy('process_role.order', 'asc')
            ->get();
    }

    public function get_roles_before($process, $order, $role_id){
      $currentRole = $process->roles()->where('role_id', '=', $role_id)->first();
      $rolesWithLowerOrder = $process->roles()
                            ->where('order', '<', $order)
                            ->orderBy('order', 'asc')
                            ->get()
                            ->toArray();
        if($currentRole->pivot->parent_role_id != null){

          $parent_id = $currentRole->pivot->parent_role_id;
            while(true){

                $parent = $process->roles()->where('role_id', '=', $parent_id)->first();
                if(isset($parent)){
                  array_push($rolesWithLowerOrder, $parent->toArray());
                }
                if($parent->pivot->parent_role_id == null || !isset($parent)){
                  break;
                }
                $parent_id = $parent->pivot->parent_role_id;
            }
        }
        // dd($rolesWithLowerOrder);

        return $rolesWithLowerOrder;
    }

    public function remove_unselected($process_roles, $selected, $process, $order, $role_id){
        $roles_for_select = $process->roles()
            ->where('order', '=', $order)
            ->where('is_selection', '=', '1')
            ->where('parent_role_id', '=', $role_id)
            ->get();
        $result = [];
        for ($i=0; $i < count($process_roles); $i++) {
            $check = true;
            foreach ($roles_for_select as $item) {
                if($process_roles[$i] == $item->pivot->role_id){
                    $check = false;
                }
            }
            if($check){
                $result[] = (int)$process_roles[$i];
            }
        }
        $result[] = (int)$selected;
        return $result;
    }

    public function get_roles_for_select($process, $order, $role_id){
        return $process->roles()
            ->where('order', '=', $order)
            ->where('is_selection', '=', '1')
            ->where('parent_role_id', '=', $role_id)
            ->get()
            ->toArray();
    }

    public function get_roles_for_edit($process_id){

        $without_parents = DB::table('roles')
            ->join('process_role', 'roles.id','=','process_role.role_id')
            ->select('process_role.id', 'roles.id as role_id', 'roles.name','process_role.order')
            ->where('process_role.process_id', $process_id)
            ->where('process_role.parent_role_id',Null)
            ->orderBy('process_role.order', 'asc')
            ->get();

        foreach($without_parents as $value) {
            $value->child = $this->add_child($process_id, $value->role_id, $value->order);
        }
        return $without_parents;
    }

    public function add_child($process_id, $role_id, $order){

        $roles = DB::table('roles')
            ->join('process_role', 'roles.id','=','process_role.role_id')
            ->select('process_role.id', 'roles.id as role_id', 'roles.name','process_role.order')
            ->where('process_role.process_id', $process_id)
            ->where('process_role.order', $order)
            ->where('process_role.parent_role_id', $role_id)
            ->orderBy('process_role.order', 'asc')
            ->get();

        foreach($roles as $value) {
            $value->child = $this->add_child($process_id, $value->role_id, $value->order);
        }
        return $roles;
    }

    private function get_applications($table_name, $table_id) {

        if(Schema::hasTable($table_name)) {
            $apps = DB::table($table_name)->get();
            foreach ($apps as $app) {
                $last_log = DB::table('logs')->where('table_id', $table_id)->where('application_id', $app->id)->latest('id')->first();
                if($last_log){
                    $app->last_status = DB::table('role_statuses')->select('string')->where('id', $last_log->status_id)->first()->string;
                }
            }
            return $apps;
        } else {
            echo 'Процесс не был сформирован полностью. Сначала завершите формирование процесса';
            exit();
        }

    }

    private function getProcessStatuses($tableName, $applicationId){
        return json_decode(DB::table($tableName)->where('id', $applicationId)->select('statuses')->first()->statuses, true);
    }

    private function getRoleChildren($process){
        return $process->roles()->where('parent_role_id', Auth::user()->role_id)->select('role_id')->get()->toArray();
    }

    private function deleteCurrentRoleFromStatuses($currentRoles){
        foreach($currentRoles as $key => $role_id){
            if($role_id == Auth::user()->role_id){
              unset($currentRoles[$key]);
              break;
            }
        }
        return $currentRoles;
    }

    public function getNextUnparallelRoleId($process, $currentRoleOrder, $application_id, $table_id){
        $my_order = $currentRoleOrder;
        $maxOrder = $process->roles()->max('order');

        while($maxOrder >= $currentRoleOrder){
            $rolesAfter = $process->roles()->where('order', $currentRoleOrder + 1)->get();
            if(sizeof($rolesAfter) == 1 && $rolesAfter[0]->isRole == 1){
                break;
            }
            $currentRoleOrder++;
        }

        if($currentRoleOrder > $maxOrder){
          return [1, 0];
        }else{
            return [$rolesAfter[0]->pivot['role_id'], $rolesAfter[0]->pivot['order']];
        }

    }

    public function getColumns($tableName)
    {
        $notInclude = ['id', 'process_id', 'status_id', 'user_id', 'reject_reason', 'reject_reason_from_spec_id', 'to_revision', 'revision_reason', 'revision_reason_from_spec_id', 'revision_reason_to_spec_id', 'updated_at', 'statuses', 'current_order', 'created_at', 'deadline_date'];
        $cols = DB::select(
          (new \Illuminate\Database\Schema\Grammars\MySqlGrammar)->compileColumnListing()
              .' order by ordinal_position',
          [env('DB_DATABASE', 'workflow'), $tableName]
        );
        $result = [];
        foreach ($cols as $value) {
            if(in_array($value->column_name, $notInclude)) continue;
            array_push($result, $value->column_name);
        }
        return $result;
    }

    public function add_app_columns($fields, $tableName, $application_id) {
        $application = DB::table($tableName)->select($this->getColumns($tableName))->where('id', $application_id)->first();
        foreach ($application as $key => $value) {
            $fields[$key] = $value;
        }
        return $fields;
    }

    public function filterArray($array, $columns) {
        $result = [];
        $i = 0;
        $size = sizeof($array);
        while ($i < $size) {
          foreach($columns as $column){
            if($array[$i] == $column){
              unset($array[$i]);
              break;
            }
          }
          $i++;
        }
        return $array;

    }

    public function addOptionsToDictionary($dictionaries) {
        foreach($dictionaries as $dictionary) {
            switch ($dictionary->inputName) {
                case 'select':
                    if($dictionary->select_dic == null){
                        $dictionary->options = DB::table('select_options')
                            ->join('dictionaries', 'select_options.dictionary_id', '=', 'dictionaries.id')
                            ->select('name_rus')
                            ->where('dictionaries.name', $dictionary->name)->get();
                    }else{
                        $dictionary->options = DB::table('select_options')
                            ->join('dictionaries', 'select_options.dictionary_id', '=', 'dictionaries.id')
                            ->select('name_rus')
                            ->where('dictionaries.name', $dictionary->select_dic)->get();
                    }
                    break;

                case 'radio_button':
                    $dictionary->options = DB::table('select_options')
                        ->join('dictionaries', 'select_options.dictionary_id', '=', 'dictionaries.id')
                        ->select('name_rus')
                        ->where('dictionaries.name', $dictionary->name)->get();
                    break;

                default:
                    # code...
                    break;
            }
        }
        return $dictionaries;
    }

    function holiday_diff_in_date($add_days = 0) {
        $dt = Carbon::parse(date('Y-m-d'));
        $holiday_list = HolidayCalendar::pluck('holiday')->toArray();

        if ($add_days) {
            for ($i = 1; $i <= $add_days; $i++) {
                $dt = $dt->addDay();

                if (in_array($dt->format('Y-m-d'), $holiday_list)) {
                    $add_days++;
                }
            }
        }
        $dt->setTime(16, 00);
        return $dt;
    }

    public function get_templates($process_id, $application_id){

        $templates = Template::select('templates.id', 'templates.table_name', 'template_docs.name', 'templates.to_citizen',
            'roles.name as role_name')
            ->join('template_docs', 'templates.template_doc_id', '=', 'template_docs.id')
            ->join('roles', 'templates.role_id', '=', 'roles.id')
            ->where('process_id', $process_id)->get();
        if($templates){
            foreach($templates as $item){
                $t_name = $item->table_name;
                $fields = DB::table($t_name)->where('application_id', $application_id)->first();
                if($fields){
                    $fields = json_decode(json_encode($fields), true);
                    $exceptionArray = ["id", "application_id"];
                    $item->fields = $this->filterTemplateFieldsTable($fields, $exceptionArray);
                    $item->fields = $this->get_field_label($item->fields, $item->id);
                }else{
                    $item->fields = [];
                }
            }
            return $templates;
        }
        return [];
    }

    public function get_field_label($fields, $template_id){
        foreach ($fields as $key => $value) {
            $data = [];
            $field = TemplateField::where('template_id', $template_id)->where('name', $key)->first();
            if($field){
                $data['label'] = $field->label_name;
            }else{
                $data['label'] = $key;
            }
            $data['value'] = $value;
            $fields[$key] = $data;
        }
        return $fields;
    }

    private function filterTemplateFieldsTable($array, $exceptionArray)
    {
        foreach($exceptionArray as $item) {
            if (isset($array[$item])) {
                unset($array[$item]);
            }
        }
        return $array;
    }

    public function getAllDictionaries($to_search = []){
        if(count($to_search) == 0){
            return DB::table('dictionaries')
            ->join('input_types', 'dictionaries.input_type_id', '=', 'input_types.id')
            ->join('insert_types', 'dictionaries.insert_type_id', '=', 'insert_types.id')
            ->select('dictionaries.name','dictionaries.label_name as labelName', 'input_types.name as inputName',
                'insert_types.name as insertName', 'dictionaries.select_dic', 'dictionaries.required')
            ->get();
        }else{
            return DB::table('dictionaries')
            ->join('input_types', 'dictionaries.input_type_id', '=', 'input_types.id')
            ->join('insert_types', 'dictionaries.insert_type_id', '=', 'insert_types.id')
            ->select('dictionaries.name','dictionaries.label_name as labelName', 'input_types.name as inputName',
                'insert_types.name as insertName', 'dictionaries.select_dic', 'dictionaries.required')
            ->whereIn('dictionaries.name', $to_search)
            ->get();
        }
    }

    public function get_dic_in_order($to_search = []) {
        $result = [];
        foreach ($to_search as $item) {
            $result[] = DB::table('dictionaries')
            ->join('input_types', 'dictionaries.input_type_id', '=', 'input_types.id')
            ->join('insert_types', 'dictionaries.insert_type_id', '=', 'insert_types.id')
            ->select('dictionaries.name','dictionaries.label_name as labelName', 'input_types.name as inputName', 'insert_types.name as insertName', 'dictionaries.select_dic')
            ->where('dictionaries.name', $item)
            ->first();
        }
        return $result;
    }

    public function get_field_options($fields) {
        foreach ($fields as $item) {
            if($item->select_dic != null){
                $item->options = DB::table('select_options')->where('dictionary_id', $item->select_dic)->get();
            }
            $def_values = DB::table('dic_default_values')->where('field_id', $item->id)->get();
            if($def_values){
                $item->def_values = $def_values;
            }
        }
        return $fields;
    }

    public function getAuctionRaws($id)
    {
        $query = DB::table('auctions')
            ->select('*')
            ->where('id',$id)
            ->get()->toArray();
        return json_decode(json_encode($query), true);
    }

    public function getAllTemplateFields($id) {

        return DB::table('template_fields')
            ->join('input_types', 'template_fields.input_type_id', '=', 'input_types.id')
            ->join('insert_types', 'template_fields.insert_type_id', '=', 'insert_types.id')
            ->leftJoin('dictionaries', 'template_fields.select_dic', '=', 'dictionaries.id')
            ->select('template_fields.*', 'input_types.name as inputName', 'insert_types.name as insertName',
                'dictionaries.label_name as dic_name')
            ->where('template_fields.template_id', $id)
            ->get();
    }

    public function getRecords($applicationId, $tableId, $region = '') {

        $query = Log::join('roles', 'logs.role_id', '=', 'roles.id')
                      ->join('role_statuses', 'logs.status_id', '=', 'role_statuses.id')
                      ->select( 'role_statuses.string as name', 'logs.comment as comment', 'logs.created_at as created_at', 'roles.name as role')
                      ->where('application_id', $applicationId)
                      ->where('table_id', $tableId)
                      ->get();

        foreach ($query as &$item) {
            if($item->name == 'Отправлено руководителю отдела городского планирования' ||
                $item->name == 'Одобрено руководителем отдела городского планирования' ||
                $item->name == 'Подписано руководителем отдела городского планирования' ||
                $item->name == 'Отклонено руководителем отдела городского планирования'){
                $item->name .= '(район '.$region.')';
            }
        }

        return json_decode(json_encode($query), true);
    }

    public function xmlGenerator($aData)
    {
        $xmlstr = "<?xml version='1.0' encoding='UTF-8' standalone='no'?><root><dataToSign>";
        if (isset($aData) && count($aData)) {
            foreach ($aData as $sKey => $sData) {
              if(is_array($sData)){
                // dd($sData);
                $sData = $this->convertArrayToXmlString($sData);
              }
              if(is_int($sKey)){
                    $xmlstr .= "<Arr".$sKey.">".$sData."</Arr".$sKey.">";
                }else{
                    $xmlstr .= "<".$sKey.">".$sData."</".$sKey.">";
                }
            }
        }
        $xmlstr .= "</dataToSign></root>";
        return $xmlstr;
    }

    private function convertArrayToXmlString($aData){ // should return string
      $xmlstr = "";
      foreach ($aData as $sKey => $sData) {
        if(is_array($sData)){
          $sData = $this->convertArrayToXmlString($sData);
        }
        if(is_int($sKey)){
            $xmlstr .= "<Arr".$sKey.">".$sData."</Arr".$sKey.">";
        }else{
            $xmlstr .= "<".$sKey.">".$sData."</".$sKey.">";
        }
      }
      return $xmlstr;
    }

}
