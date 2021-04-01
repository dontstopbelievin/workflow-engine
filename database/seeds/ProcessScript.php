<?php

use Illuminate\Database\Seeder;
use App\Process;
use App\CityManagement;

class ProcessScript extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        //Определение делимости и неделимости земельных участков
    	$process = Process::where('name', 'Определение делимости и неделимости земельных участков')->first();
        //org name
        $org = CityManagement::where('name', 'Управление архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->main_organization_id = $org->id;
        $process->save();
        //create process application table
        $request = new \Illuminate\Http\Request();
        $request->replace(['fields' => ['applicant_address', 'first_name', 'middle_name', 'surname', 'region', 'ulica_mestop_z_u', 'dictionary_purpose', 'dictionary_right_type', 'cel_razdela']]);
        app('App\Http\Controllers\ProcessController')->createProcessTable($request, $process);
        //add process roles
        $role = Role::where('name', 'Руководитель архитектурно-планировочного отдела')->first();
        $process->roles()->attach($role->id, [
            'can_reject' => 1,
            'can_send_to_revision' => 0,
            'can_ecp_sign' => 0,
            'can_motiv_otkaz' => 0,
            'order' => 1
        ]);
        //'parent_role_id' => $request->parent_role_id,
        $role = Role::where('name', 'Руководитель отдела городского планирования')->first();
        $process->roles()->attach($role->id, [
            'can_reject' => 1,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 0,
            'can_motiv_otkaz' => 0,
            'order' => 2
        ]);
        $role = Role::where('name', 'Специалист отдела земельного кадастра')->first();
        $process->roles()->attach($role->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 0,
            'can_motiv_otkaz' => 1,
            'order' => 3
        ]);
        $role = Role::where('name', 'Руководитель отдела земельного кадастра')->first();
        $process->roles()->attach($role->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 0,
            'can_motiv_otkaz' => 0,
            'order' => 4
        ]);
        $role = Role::where('name', 'Заместитель руководителя управления архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->roles()->attach($role->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 0,
            'can_motiv_otkaz' => 0,
            'order' => 5
        ]);
    }
}