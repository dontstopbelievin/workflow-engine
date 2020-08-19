<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

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
}