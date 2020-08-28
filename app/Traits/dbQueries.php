<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Dictionary;

trait dbQueries
{
    public function getRolesWithoutParent($id) {

        $res = DB::table('roles')
        ->join('process_role', 'roles.id','=','process_role.role_id')
        ->select('name')
        ->where('process_role.process_id',$id)
        ->where('process_role.parent_role_id',Null)
        ->get();
        return $res;
    }

    public function getParentRoleId($id) {

        $parentRoleId = DB::table('process_role')
        ->select('parent_role_id')
        ->where('process_id', $id)
        ->where('parent_role_id', '<>' ,Null)
        ->limit(1)
        ->get()->toArray();
        $arrayId = json_decode(json_encode($parentRoleId), true);
        if (empty($arrayId)) {
            return 0;
        }
        return intval($arrayId[0]['parent_role_id']);
    }


    public function getAllRoles($process, $parentId, $iterateRoles) {

        $sAllRoles = array();
        $sTmp = $this->getSubRoutes($process->id);
        $counter = 0;
        foreach($iterateRoles as $key => $value) {
            $counter++;
            $sAllRoles[$value->name] = $value->id;   
            if ($value->id === $parentId) {
                $sAllRoles[$value->name] = $sTmp;
            }
        }
        return $sAllRoles;
    }

    public function getIterateRoles($process) {

        $rolesWithoutParent = $this->getRolesWithoutParent($process->id);
        $countRolesWithoutParent = count($rolesWithoutParent);
        return $process->roles->take($countRolesWithoutParent);
    }

    public function getAppRoutes($id) {

        $routes = DB::table('roles')
            ->join('process_role', 'roles.id','=', 'process_role.role_id')
            ->select('name')
            ->where('process_role.process_id', '=', $id)
            ->where('parent_role_id', null)
            ->get()->toArray();
        $array = json_decode(json_encode($routes), true);
        $res = array();
        foreach($array as  $arr) {
            foreach($arr as $key => $value) {
                array_push($res, $value);
            }
        }
        return json_encode($res);
    }
    public function getTableWithStatuses($table) {
        return DB::table($table)
            ->join('statuses', $table.'.status_id','=', 'statuses.id')
            ->select($table.'.*', 'statuses.name as status')
            ->get()->toArray();
    }

    public function getRecords($id) {

        return DB::table('statuses')
        ->join('application_status', 'statuses.id', '=', 'application_status.status_id')
        ->select('statuses.name', 'application_status.updated_at')
        ->where('application_status.application_id', $id)
        
        ->get();
    }
    public function getSubRoutes($id) {

        $routes = DB::table('roles')
        ->join('process_role', 'roles.id','=','process_role.role_id')
        ->select('name')
        ->where('process_role.process_id',$id)
        ->where('process_role.parent_role_id', '<>','null')
        ->get()->toArray();
        $array = json_decode(json_encode($routes), true);
        $res = array();
        foreach($array as  $arr) {
            foreach($arr as $key => $value) {
                array_push($res, $value);
            }
        }
        return $res;
    }

    public function getOptionsOfThisSelect($name) {

        $dics = Dictionary::where('name', $name)->first()->selectOptions()->get();
        $selectedOptions = [];
        foreach ($dics as $dic) {
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

    public function getAllDictionaries() {
        $query = DB::table('dictionaries')
            ->join('input_types', 'dictionaries.input_type_id', '=', 'input_types.id')
            ->join('insert_types', 'dictionaries.insert_type_id', '=', 'insert_types.id')
            ->select('dictionaries.name', 'input_types.name as inputName', 'insert_types.name as insertName')
            ->get()->toArray();
        $res = json_decode(json_encode($query), true);
        return $res;
    }
    public function getColumns($tableName) {
        $tableColumns = Schema::getColumnListing($tableName);
        return $this->filterArray($tableColumns);
    }

    public function getTableName($table) {
        $tableName = $this->translateSybmols($table);
        return str_replace(' ', '_', $tableName);
    }

    public function getOriginalColumns($tableColumns) {
        $array = [];
        foreach ($tableColumns as $column) {
            array_push($array, str_replace('_', ' ', $column));
        }
        return $array;
    }
    public function filterArray($array) {
        $result = [];
        foreach($array as $item) {
            if (($item != "id") && ($item != "process_id")) {
                array_push($result, $item);
            }
        }
        return $result;

    }
    public function addOptionsToDictionary($dictionaries) {
        $array = [];
        foreach($dictionaries as $dictionary) {

            if($dictionary["inputName"] === 'select') {
                $options = $this->getOptionsOfThisSelect($dictionary["name"]);
                $dictionary["inputName"] = $options;
            }
            array_push($array, $dictionary);
        }
        return $array;
    }
}
