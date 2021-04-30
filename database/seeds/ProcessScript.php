<?php

use Illuminate\Database\Seeder;
use App\Process;
use App\CityManagement;
use App\Role;
use App\Template;
use App\TemplateDoc;
use App\Dictionary;

class ProcessScript extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->create_delimost();
        $this->create_eskiz();
        $this->create_u4astok_v_nas_punkte_1();
        $this->create_u4astok_v_nas_punkte_2();
        $this->create_izmen_cel_nazna4();
        $this->create_bez_torgov1();
    }

    public function create_u4astok_v_nas_punkte_2(){
        //Согласование эскизного проекта
        $process = Process::where('name', 'Предоставление земельного участка для строительства объекта в черте населенного пункта(этап 2)')->first();
        //org name
        $org = CityManagement::where('name', 'Управление архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->main_organization_id = $org->id;
        $process->need_map = 1;
        $process->save();
        //create process application table
        $request = new \Illuminate\Http\Request();

        $request->replace(['fields' => ['first_name', 'middle_name', 'sur_name', 'applicant_address', 'region', 'iin', 'bin', 'telephone', 'zakaz4ik_drugoi', 'zakaz4ik_fiz_ur', 'name_organization', 'object_address', 'object_name', 'area', 'dictionary_purpose']]);
        app('App\Http\Controllers\ProcessController')->createProcessTable($request, $process);
        //add process roles
        $role1 = Role::where('name', 'Специалист отдела земельного кадастра')->first();
        $process->roles()->attach($role1->id, [
            'can_reject' => 1,
            'can_send_to_revision' => 0,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 1
        ]);
        $role2 = Role::where('name', 'Руководитель отдела земельного кадастра')->first();
        $process->roles()->attach($role2->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 2
        ]);
        //'parent_role_id' => $request->parent_role_id,
        $role3 = Role::where('name', 'Заместитель руководителя управления архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->roles()->attach($role3->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 1,
            'order' => 3
        ]);

        $role4 = Role::where('name', 'Отдел земельной комиссии')->first();
        $process->roles()->attach($role4->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 1,
            'order' => 4
        ]);

        $role5 = Role::where('name', 'Заместитель руководителя управления архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->roles()->attach($role5->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 1,
            'order' => 5
        ]);

        //create template 1
        $request = new \Illuminate\Http\Request();
        $template_doc = TemplateDoc::where('name', 'Предоставление ЗУ в черте населенного пункта')->first();
        $request->replace(['template_state' => 1, 'table_name' => 'p9_pred_zem_v_4erte', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role2->id, 'order' => 2, 'to_citizen' => 1]);
        app('App\Http\Controllers\TemplateController')->store($request);
    }

    public function create_u4astok_v_nas_punkte_1(){
        //Согласование эскизного проекта
        $process = Process::where('name', 'Предоставление земельного участка для строительства объекта в черте населенного пункта')->first();
        //org name
        $org = CityManagement::where('name', 'Управление архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->main_organization_id = $org->id;
        $process->need_map = 1;
        $process->save();
        //create process application table
        $request = new \Illuminate\Http\Request();

        $request->replace(['fields' => ['first_name', 'middle_name', 'sur_name', 'applicant_address', 'region', 'iin', 'bin', 'telephone', 'zakaz4ik_drugoi', 'zakaz4ik_fiz_ur', 'name_organization', 'object_address', 'object_name', 'area', 'dictionary_purpose']]);
        app('App\Http\Controllers\ProcessController')->createProcessTable($request, $process);
        //add process roles
        $role1 = Role::where('name', 'Специалист отдела выдачи разрешительных документов на реконструкцию, градостроительного кадастра и учета введенных в эксплуатацию объектов, договоров долевого участия')->first();
        $process->roles()->attach($role1->id, [
            'can_reject' => 1,
            'can_send_to_revision' => 0,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 1
        ]);
        $role2 = Role::where('name', 'Заместитель директора ТОО "Астанагорархитектура"')->first();
        $process->roles()->attach($role2->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 2
        ]);
        //'parent_role_id' => $request->parent_role_id,
        $role3 = Role::where('name', 'Руководитель отдела городского планирования')->first();
        $process->roles()->attach($role3->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 1,
            'order' => 3
        ]);

        $role4 = Role::where('name', 'Руководитель отдела мониторинга ТОО "Астанагорархитектура"')->first();
        $process->roles()->attach($role4->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 1,
            'order' => 4
        ]);

        $role5 = Role::where('name', 'Руководитель архитектурно-планировочного отдела')->first();
        $process->roles()->attach($role5->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 1,
            'order' => 5
        ]);

        $role6 = Role::where('name', 'Руководитель управления архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->roles()->attach($role6->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 1,
            'order' => 5
        ]);
    }

    public function create_eskiz(){
        //Согласование эскизного проекта
        $process = Process::where('name', 'Согласование эскизного проекта')->first();
        //org name
        $org = CityManagement::where('name', 'Управление архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->main_organization_id = $org->id;
        $process->need_map = 1;
        $process->save();
        //create process application table
        $request = new \Illuminate\Http\Request();

        $request->replace(['fields' => ['first_name', 'middle_name', 'sur_name', 'applicant_address', 'region', 'iin', 'telephone', 'zakaz4ik_drugoi', 'zakaz4ik_fiz_ur', 'iin_zakaz4ika', 'name_fiz_zakaz4ika', 'bin_zakaz4ika', 'name_ur_zakaz4ika', 'designer', 'gsl_number', 'gsl_date', 'object_address', 'object_name', 'cadastral_number', 'eskiz_proekt']]);
        app('App\Http\Controllers\ProcessController')->createProcessTable($request, $process);
        //add process roles
        $role1 = Role::where('name', 'Руководитель отдела рассмотрения эскизных проектов и наружной рекламы')->first();
        $process->roles()->attach($role1->id, [
            'can_reject' => 1,
            'can_send_to_revision' => 0,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 1
        ]);
        //'parent_role_id' => $request->parent_role_id,
        $role2 = Role::where('name', 'Руководитель отдела подготовки и выдачи исходных данных')->first();
        $process->roles()->attach($role2->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 1,
            'order' => 2
        ]);
        $role3 = Role::where('name', 'Заместитель директора ТОО "Астанагорархитектура"')->first();
        $process->roles()->attach($role3->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 3
        ]);
        $role4 = Role::where('name', 'Руководитель отдела рассмотрения эскизных проектов и наружной рекламы')->first();
        $process->roles()->attach($role4->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 4
        ]);
        $role5 = Role::where('name', 'Заместитель руководителя управления архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->roles()->attach($role5->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 5
        ]);
        //create template 1
        $request = new \Illuminate\Http\Request();
        $template_doc = TemplateDoc::where('name', 'Шаблон эскизного проекта')->first();
        $request->replace(['template_state' => 1, 'table_name' => 'p3_eskiz', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role2->id, 'order' => 2, 'to_citizen' => 1]);
        app('App\Http\Controllers\TemplateController')->store($request);
    }

    public function create_delimost(){
        //Определение делимости и неделимости земельных участков
        $process = Process::where('name', 'Определение делимости и неделимости земельных участков')->first();
        //org name
        $org = CityManagement::where('name', 'Управление архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->main_organization_id = $org->id;
        $process->need_map = 1;
        $process->save();
        //create process application table
        $request = new \Illuminate\Http\Request();
        $request->replace(['fields' => ['first_name', 'middle_name', 'sur_name', 'applicant_address', 'region', 'ulica_mestop_z_u', 'dictionary_purpose', 'pravo_ru', 'object_name', 'cadastral_number', 'cel_razdela']]);
        app('App\Http\Controllers\ProcessController')->createProcessTable($request, $process);
        //add process roles
        $role1 = Role::where('name', 'Руководитель архитектурно-планировочного отдела')->first();
        $process->roles()->attach($role1->id, [
            'can_reject' => 1,
            'can_send_to_revision' => 0,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 1
        ]);
        //'parent_role_id' => $request->parent_role_id,
        $role2 = Role::where('name', 'Руководитель отдела городского планирования')->first();
        $process->roles()->attach($role2->id, [
            'can_reject' => 1,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 2
        ]);
        $role3 = Role::where('name', 'Специалист отдела земельного кадастра')->first();
        $process->roles()->attach($role3->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 0,
            'can_motiv_otkaz' => 1,
            'order' => 3
        ]);
        $role4 = Role::where('name', 'Руководитель отдела земельного кадастра')->first();
        $process->roles()->attach($role4->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 4
        ]);
        $role5 = Role::where('name', 'Заместитель руководителя управления архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->roles()->attach($role5->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 5
        ]);
        //create template 1
        $request = new \Illuminate\Http\Request();
        $template_doc = TemplateDoc::where('name', 'Без шаблона')->first();
        $request->replace(['template_state' => 1, 'table_name' => 'p8_shema_i_zaklu4', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role1->id, 'order' => 1, 'to_citizen' => 0]);
        app('App\Http\Controllers\TemplateController')->store($request);
        //add template field
        $request = new \Illuminate\Http\Request();
        $template = Template::where('table_name', 'wf_tt_p8_shema_i_zaklu4')->first();
        $request->replace(['fieldName' => 'shema_i_zaklu4', 'labelName' => 'Схема и Заключение', 'inputItem' => 2, 'insertItem' => 1, 'temp_id' => $template->id]);
        app('App\Http\Controllers\TemplateFieldController')->store($request);
        //create template 2
        $request = new \Illuminate\Http\Request();
        $request->replace(['template_state' => 1, 'table_name' => 'p8_zaklu4', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role2->id, 'order' => 2, 'to_citizen' => 0]);
        app('App\Http\Controllers\TemplateController')->store($request);
        //add template field
        $request = new \Illuminate\Http\Request();
        $template = Template::where('table_name', 'wf_tt_p8_zaklu4')->first();
        $request->replace(['fieldName' => 'zaklu4', 'labelName' => 'Заключение', 'inputItem' => 2, 'insertItem' => 1, 'temp_id' => $template->id]);
        app('App\Http\Controllers\TemplateFieldController')->store($request);
        //create template 3
        $request = new \Illuminate\Http\Request();
        $template_doc = TemplateDoc::where('name', 'Шаблон определение делимости')->first();
        $request->replace(['template_state' => 1, 'table_name' => 'p8_pismo', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role3->id, 'order' => 3, 'to_citizen' => 1]);
        app('App\Http\Controllers\TemplateController')->store($request);
        $template = Template::where('table_name', 'wf_tt_p8_pismo')->first();
        //add template field
        $request = new \Illuminate\Http\Request();
        $request->replace(['fieldName' => 'pdp_name', 'labelName' => 'Наименование ПДП', 'inputItem' => 1, 'insertItem' => 1, 'temp_id' => $template->id]);
        app('App\Http\Controllers\TemplateFieldController')->store($request);
        //add template field
        // $request = new \Illuminate\Http\Request();
        // $request->replace(['fieldName' => 'object_name', 'labelName' => 'Наименование объекта', 'inputItem' => 1, 'insertItem' => 1, 'temp_id' => $template->id]);
        // app('App\Http\Controllers\TemplateFieldController')->store($request);
        //add template field
        // $request = new \Illuminate\Http\Request();
        // $request->replace(['fieldName' => 'cadastral_number', 'labelName' => 'Кадастровый номер', 'inputItem' => 1, 'insertItem' => 1, 'temp_id' => $template->id]);
        // app('App\Http\Controllers\TemplateFieldController')->store($request);
        //add template field
        $request = new \Illuminate\Http\Request();
        $select_dic = Dictionary::where('name', 'dictionary_land_divisibility')->first();
        $request->replace(['fieldName' => 'division', 'labelName' => 'Делимость', 'inputItem' => 3, 'insertItem' => 1, 'temp_id' => $template->id, 'select_dic' => $select_dic->id]);
        app('App\Http\Controllers\TemplateFieldController')->store($request);
    }
    public function create_bez_torgov1(){
        //Согласование эскизного проекта
        $process = Process::where('name', 'Приобретение прав на земельные участки которые находятся в государственной собственности не требующее проведения торгов')->first();
        //org name
        $org = CityManagement::where('name', 'Управление архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->main_organization_id = $org->id;
        $process->need_map = 1;
        $process->save();
        //create process application table
        $request = new \Illuminate\Http\Request();

        $request->replace(['fields' => ['region', 'first_name', 'middle_name', 'sur_name', 'iin', 'telephone', 'applicant_address', 'object_address', 'pravo_ru', 'area', 'dictionary_purpose', 'zakaz4ik_drugoi', 'zakaz4ik_fiz_ur', 'iin_zakaz4ika', 'name_fiz_zakaz4ika', 'bin_zakaz4ika', 'name_ur_zakaz4ika', 'cadastral_number', 'shema_isprash_u4astka']]);
        app('App\Http\Controllers\ProcessController')->createProcessTable($request, $process);
        //add process roles
        $role1 = Role::where('name', 'Заместитель директора ТОО "Астанагорархитектура"')->first();
        $process->roles()->attach($role1->id, [
            'can_reject' => 1,
            'can_send_to_revision' => 0,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 1
        ]);
        //'parent_role_id' => $request->parent_role_id,
        $role2 = Role::where('name', 'Руководитель архитектурно-планировочного отдела')->first();
        $process->roles()->attach($role2->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 1,
            'order' => 2
        ]);
        $role3 = Role::where('name', 'Руководитель отдела мониторинга ТОО "Астанагорархитектура"')->first();
        $process->roles()->attach($role3->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 3
        ]);
        $role4 = Role::where('name', 'Заместитель директора ТОО "Астанагорархитектура"')->first();
        $process->roles()->attach($role4->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 4
        ]);
        $role5 = Role::where('name', 'Руководитель отдела организации работы земельной комиссии')->first();
        $process->roles()->attach($role5->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 5
        ]);
        $role6 = Role::where('name', 'Заместитель руководителя управления архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->roles()->attach($role6->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 6
        ]);
        //create template
        $request = new \Illuminate\Http\Request();
        $template_doc = TemplateDoc::where('name', 'Без шаблона')->first();
        $request->replace(['template_state' => 1, 'table_name' => 'p7_files_apo', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role2->id, 'order' => 2, 'to_citizen' => 1]);
        app('App\Http\Controllers\TemplateController')->store($request);
        
        //add template field
        $request = new \Illuminate\Http\Request();
        $template = Template::where('table_name', 'wf_tt_p7_files_apo')->first();
        $request->replace(['fieldName' => 'files_apo', 'labelName' => 'Файлы', 'inputItem' => 2, 'insertItem' => 1, 'temp_id' => $template->id]);
        app('App\Http\Controllers\TemplateFieldController')->store($request);
        
        //create template
        $request = new \Illuminate\Http\Request();
        $template_doc = TemplateDoc::where('name', 'Без шаблона')->first();
        $request->replace(['template_state' => 1, 'table_name' => 'p7_files_monitoring', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role3->id, 'order' => 3, 'to_citizen' => 1]);
        app('App\Http\Controllers\TemplateController')->store($request);
        
        //add template field
        $request = new \Illuminate\Http\Request();
        $template = Template::where('table_name', 'wf_tt_p7_files_monitoring')->first();
        $request->replace(['fieldName' => 'files_monitoring', 'labelName' => 'Файлы', 'inputItem' => 2, 'insertItem' => 1, 'temp_id' => $template->id]);
        app('App\Http\Controllers\TemplateFieldController')->store($request);
        
        //final doc template
        $request = new \Illuminate\Http\Request();
        $template_doc = TemplateDoc::where('name', 'Шаблон 1 часть приобретение прав на ЗУ')->first();
        $request->replace(['template_state' => 1, 'table_name' => 'p7_vypiska_protokola', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role5->id, 'order' => 5, 'to_citizen' => 1]);
        app('App\Http\Controllers\TemplateController')->store($request);
    }
}