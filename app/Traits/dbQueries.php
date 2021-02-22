<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use App\Dictionary;
use App\Log;
use App\Role;
use App\Status;

trait dbQueries
{
    public function getRolesWithoutParent($id) {

        $res = DB::table('roles')
        ->join('process_role', 'roles.id','=','process_role.role_id')
        ->select('roles.id', 'roles.name')
        ->where('process_role.process_id',$id)
        ->where('process_role.parent_role_id',Null)
        ->orderBy('process_role.id', 'asc')
        ->get();
        return $res;
    }

    private function getButtons($processId, $roleId)
    {
        return DB::table('process_role')
            ->where('process_id', $processId)
            ->where('role_id', $roleId)
            ->get()
            ->toArray();
    }

    // private function checkIfRoutesInParallel($processId) {
    //     $parallelRoutesExist = DB::table('process_role')
    //         ->where('process_id', $processId)
    //         ->where('approve_in_parallel', '!=', Null)
    //         ->exists();
    //     return $parallelRoutesExist;
    // }

    private function getParallelRoutes($processId) {
        $parallelRoutes = DB::table('process_role')
            ->where('process_id', $processId)
            ->where('approve_in_parallel', '!=', Null)
            ->get();

        return json_decode(json_encode($parallelRoutes), true);
    }

    private function getSortedParallelRoutes($processId) {
        $allParallelRoutes = $this->getParallelRoutes($processId);
//        $tempLevel=0;
        $newKey=0;
        foreach ($allParallelRoutes as $key => $val) {
//            if ($tempLevel==$val['approve_in_parallel']){
//                $groupArr[$tempLevel][$newKey]=$val;
//            } else {
//                $groupArr[$val['approve_in_parallel']][$newKey]=$val;
//            }
//            $newKey++;
            $groupArr[$val['approve_in_parallel']][$newKey]=$val;
            $newKey++;
        }
        return $groupArr;
    }

    // public function getParentRoleId($id) {

    //     $parentRoleId = DB::table('process_role')
    //     ->select('parent_role_id')
    //     ->where('process_id', $id)
    //     ->where('parent_role_id', '!=' ,Null)
    //     ->limit(1)
    //     ->get()->toArray();
    //     $arrayId = json_decode(json_encode($parentRoleId), true);
    //     if (empty($arrayId)) {
    //         return 0;
    //     }
    //     return intval($arrayId[0]['parent_role_id']);
    // }

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

    public function get_roles_for_edit($process_id){

        $without_parents = DB::table('roles')
            ->join('process_role', 'roles.id','=','process_role.role_id')
            ->select('process_role.id', 'roles.id as role_id', 'roles.name','process_role.order')
            ->where('process_role.process_id', $process_id)
            ->where('process_role.parent_role_id',Null)
            ->orderBy('process_role.order', 'asc')
            ->get();

        foreach($without_parents as $value) {
            $value->child = $this->add_child($process_id, $value->role_id);
        }
        return $without_parents;
    }

    public function add_child($process_id, $role_id){

        $roles = DB::table('roles')
            ->join('process_role', 'roles.id','=','process_role.role_id')
            ->select('process_role.id', 'roles.id as role_id', 'roles.name','process_role.order')
            ->where('process_role.process_id', $process_id)
            ->where('process_role.parent_role_id', $role_id)
            ->orderBy('process_role.order', 'asc')
            ->get();

        foreach($roles as $value) {
            $value->child = $this->add_child($process_id, $value->role_id);
        }
        return $roles;
    }

    public function getAllRoles($process, $parentId, $iterateRoles) {

        $sAllRoles = array();
        $sTmp = $this->getSubRoutes($process->id);

        foreach($iterateRoles as $key => $value) {
            $sAllRoles[$value->name] = $value->id;
            if ($value->id === $parentId) {
                $sAllRoles[$value->name] = $sTmp;
            }
        }
        return $sAllRoles;
    }

    public function getIterateRoles($process) {
        $rolesWithoutParent = $this->getRolesWithoutParent($process->id);
        return $process->roles->take(count($rolesWithoutParent));
    }

    public function getAppRoutes($id) {

        $routes = DB::table('roles')
            ->join('process_role', 'roles.id','=', 'process_role.role_id')
            ->select('roles.id', 'roles.name')
            ->where('process_role.process_id', '=', $id)
            ->where('parent_role_id', null)
            ->get();
        return json_decode($routes, true);
    }

    private function getApplications($table_name, $table_id) {

        if(Schema::hasTable($table_name)) {
            $apps = DB::table($table_name)->get();
            foreach ($apps as $app) {
                $last_log = DB::table('logs')->where('table_id', $table_id)->where('application_id', $app->id)->latest('created_at')->first();
                if($last_log){
                    $app->last_status = Status::select('name')->where('id', $last_log->status_id)->first()->name;
                }
            }
            return $apps;
        } else {
            echo 'Процесс не был сформирован полностью. Сначала завершите формирование процесса';
            exit();
        }

    }

    private function checkIfAppHasMultipleStatuses($table)
    {
        return DB::table($table)->where('statuses', '!=', Null)->exists();
    }

    private function getProcessStatuses($tableName, $applicationId){
        return json_decode(DB::table($tableName)->where('id', $applicationId)->select('statuses')->first()->statuses, true);
    }

    private function getRoleChildren($process){
        return $process->roles()->where('parent_role_id', Auth::user()->role_id)->get();
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
            if(sizeof($rolesAfter) == 1){
                break;
            }
            $currentRoleOrder++;
        }

        if($currentRoleOrder > $maxOrder){
          return [1, 0];
        }else{
            $role = Role::select('name')->where('id', $rolesAfter[0]->pivot['role_id'])->first();
            $role_status = DB::table('role_statuses')->where('role_name', $role->name)->where('status_id', 4)->first();
            $logsArray = app('App\Http\Controllers\ApplicationController')->getLogs($role_status->id, $table_id, $application_id, Auth::user()->role_id, $my_order, 0);
            Log::insert($logsArray);
            return [$rolesAfter[0]->pivot['role_id'], $rolesAfter[0]->pivot['order']];
        }

    }

    public function getSubRoutes($id) {

        $routes = DB::table('roles')
        ->join('process_role', 'roles.id','=','process_role.role_id')
        ->select('name')
        ->where('process_role.process_id',$id)
        ->where('process_role.parent_role_id', '!=','null')
        ->get();
        $array = json_decode($routes, true);
        $res = array();
        foreach($array as  $arr) {
            foreach($arr as $key => $value) {
                array_push($res, $value);
            }
        }
        return $res;
    }

    public function getOptionsOfThisSelect($name) {

        $dictionaries = Dictionary::where('name', $name)->first()->selectOptions()->get();
        $selectedOptions = [];
        foreach ($dictionaries as $dic) {
            array_push($selectedOptions, $dic->name);
        }
        return $selectedOptions;
    }

    public function translateSybmols($text) {

        $rus=array('А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',' ');
        $lat=array('a','b','v','g','d','e','e','gh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sch','y','y','y','e','yu','ya','a','b','v','g','d','e','e','gh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sch','y','y','y','e','yu','ya',' ');
        return str_replace($rus, $lat, $text);
    }
    public function translateSybmolsBack($text) {

        $rus=array('А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',' ');
        $lat=array('a','b','v','g','d','e','e','gh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sch','y','y','y','e','yu','ya','a','b','v','g','d','e','e','gh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sch','y','y','y','e','yu','ya',' ');
        return str_replace($lat, $rus,  $text);
    }

    public function isRussian($text) {

        return preg_match('/[А-Яа-яЁё]/u', $text);
    }
    public function isEnglish($text) {

        return preg_match('/[A-Za-z]/u', $text);
    }

    public function getColumns($tableName) {
        $notInclude = ['id', 'process_id', 'status_id', 'user_id', 'index_sub_route', 'index_main', 'doc_path', 'reject_reason', 'reject_reason_from_spec_id', 'to_revision', 'revision_reason', 'revision_reason_from_spec_id', 'revision_reason_to_spec_id', 'updated_at', 'statuses', 'current_order'];
        $tableColumns = Schema::getColumnListing($tableName);
        return $this->filterArray($tableColumns, $notInclude);
    }

    public function getTableName($table) {
        $tableName = $this->translateSybmols($table);
        if (strlen($tableName) > 60) {
            $tableName = substr($tableName, 0, 60);
        }
        $tableName = 'wf_'.$tableName;
        return $this->checkForWrongCharacters($tableName);
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
        $array = [];
        foreach($dictionaries as $dictionary) {

            if($dictionary->inputName === 'select') {
                $options = $this->getOptionsOfThisSelect($dictionary->name);
                $dictionary->inputName = $options;
            }
            array_push($array, $dictionary);
        }
        return $array;
    }

    public function getAllDictionaries($to_search = []) {
        if(count($to_search) == 0){
            return DB::table('dictionaries')
            ->join('input_types', 'dictionaries.input_type_id', '=', 'input_types.id')
            ->join('insert_types', 'dictionaries.insert_type_id', '=', 'insert_types.id')
            ->select('dictionaries.name','dictionaries.label_name as labelName', 'input_types.name as inputName', 'insert_types.name as insertName')
            ->get();
        }else{
            return DB::table('dictionaries')
            ->join('input_types', 'dictionaries.input_type_id', '=', 'input_types.id')
            ->join('insert_types', 'dictionaries.insert_type_id', '=', 'insert_types.id')
            ->select('dictionaries.name','dictionaries.label_name as labelName', 'input_types.name as inputName', 'insert_types.name as insertName')
            ->whereIn('dictionaries.name', $to_search)
            ->get();
        }
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

        $query = DB::table('template_fields')
            ->join('input_types', 'template_fields.input_type_id', '=', 'input_types.id')
            ->join('insert_types', 'template_fields.insert_type_id', '=', 'insert_types.id')
            ->join('roles', 'template_fields.can_edit_role_id', '=', 'roles.id')
            ->select('template_fields.name','template_fields.label_name as labelName', 'input_types.name as inputName', 'insert_types.name as insertName', 'template_fields.template_id as templateId', 'roles.name as can_edit')
            ->where('template_fields.template_id', $id)
            ->get()->toArray();
        return json_decode(json_encode($query), true);
    }

    public function mergeRoles($mainRoles, $subRoles) {

        $mainRolesNames = [];
        foreach($mainRoles as $role) {
            array_push($mainRolesNames, $role->name);
        }
        return array_merge($mainRolesNames, $subRoles);
    }

    public function getMainRoleArray($mainRoles) {

        $mainRoleArr = [];
        foreach ($mainRoles as $role) {
            array_push($mainRoleArr, $role->name);
        }
        return $mainRoleArr;
    }

    public function getRecords($applicationId, $tableId) {

        $query = Log::join('roles', 'logs.role_id', '=', 'roles.id')
                      ->join('role_statuses', 'logs.status_id', '=', 'role_statuses.id')
                      ->select( 'role_statuses.string as name', 'logs.comment as comment', 'logs.created_at as created_at', 'roles.name as role')
                      ->where('application_id', $applicationId)
                      ->where('table_id', $tableId)
                      ->get()->toArray();

        return json_decode(json_encode($query), true);
    }

    public function filterApplicationArray($array, $notInArray){

        $res = [];
        foreach($array as $key=>$value) {
            if (!in_array($key, $notInArray)) {
                $res[$key] = $value;
            }
        }
        return $res;
    }

    public function checkForWrongCharacters($name) {

        $chars = array('!', ' ', '-', '?');
        return str_replace($chars, '_', $name);
    }

    public function modifyTemplateTable($name) {

        return 'wf_tt_'.$name;
    }
}
