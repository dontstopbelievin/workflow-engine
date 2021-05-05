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
        $this->create_bez_torgov1();
        $this->create_bez_torgov2();
        $this->create_izmen_cel_nazna4();
        $this->create_formirovanie_zu();
        $this->create_provedenie_izyskatelskih();
        $this->create_privle4enie_dolwikov();
        $this->create_postutilizacia_obektov();
    }

    public function create_izmen_cel_nazna4(){
        //Изменение целевого назначения
        $process = Process::where('name', 'Выдача решения на изменение целевого назначения земельного участка')->first();
        //org name
        $org = CityManagement::where('name', 'Управление архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->main_organization_id = $org->id;
        $process->need_map = 1;
        $process->save();
        //create process application table
        $request = new \Illuminate\Http\Request();

        $request->replace(['fields' => ['first_name', 'middle_name', 'sur_name', 'applicant_address', 'region', 'iin', 'bin', 'telephone', 'zakaz4ik_drugoi', 'zakaz4ik_fiz_ur', 'name_organization', 'iin_zakaz4ika', 'name_fiz_zakaz4ika', 'bin_zakaz4ika', 'name_ur_zakaz4ika', 'object_address', 'object_name', 'area', 'cadastral_number', 'pravo_ru', 'construction_name_before', 'construction_name_after', 'pri4ina_i_c_n', 'identific_doc_num', 'identific_doc_date', 'identific_doc', 'pravoustan_doc_num', 'pravoustan_doc_date', 'pravoustan_doc', 'act_opred_oceno4_stoim', 'gosakt', 'postanovlenie', 'dogovor_kup_prodaj']]);
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
        $role2 = Role::where('name', 'Руководитель отдела городского планирования')->first();
        $process->roles()->attach($role2->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 2
        ]);
        //'parent_role_id' => $request->parent_role_id,
        $role3 = Role::where('name', 'Руководитель отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель')->first();
        $process->roles()->attach($role3->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 1,
            'order' => 3
        ]);

        $role4 = Role::where('name', 'Руководитель отдела организации работы земельной комиссии')->first();
        $process->roles()->attach($role4->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 1,
            'order' => 4
        ]);

        //create template 1
        $request = new \Illuminate\Http\Request();
        $template_doc = TemplateDoc::where('name', 'Без шаблона')->first();
        $request->replace(['template_state' => 1, 'table_name' => 'p5_shema_i_zaklu4', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role1->id, 'order' => 1, 'to_citizen' => 0]);
        app('App\Http\Controllers\TemplateController')->store($request);
        //add template field
        $template = Template::where('table_name', 'p5_shema_i_zaklu4')->first();
        $request = new \Illuminate\Http\Request();
        $request->replace(['fieldName' => 'shema_i_zaklu4', 'labelName' => 'Схема и Заключение', 'inputItem' => 2, 'insertItem' => 1, 'temp_id' => $template->id]);
        app('App\Http\Controllers\TemplateFieldController')->store($request);

        //create template 2
        $request = new \Illuminate\Http\Request();
        $template_doc = TemplateDoc::where('name', 'Без шаблона')->first();
        $request->replace(['template_state' => 1, 'table_name' => 'p5_spravka', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role2->id, 'order' => 2, 'to_citizen' => 0]);
        app('App\Http\Controllers\TemplateController')->store($request);
        //add template field
        $template = Template::where('table_name', 'p5_spravka')->first();
        $request = new \Illuminate\Http\Request();
        $request->replace(['fieldName' => 'spravka', 'labelName' => 'Справка для отдела заключения договоров', 'inputItem' => 2, 'insertItem' => 1, 'temp_id' => $template->id]);
        app('App\Http\Controllers\TemplateFieldController')->store($request);

        //create template 2
        $request = new \Illuminate\Http\Request();
        $template_doc = TemplateDoc::where('name', 'Без шаблона')->first();
        $request->replace(['template_state' => 1, 'table_name' => 'p5_file_bez_fila', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role3->id, 'order' => 3, 'to_citizen' => 0]);
        app('App\Http\Controllers\TemplateController')->store($request);
        //add template field
        $template = Template::where('table_name', 'p5_file_bez_fila')->first();
        $request = new \Illuminate\Http\Request();
        $request->replace(['fieldName' => 'file_bez_fila', 'labelName' => 'Дополнительный файл', 'inputItem' => 2, 'insertItem' => 1, 'temp_id' => $template->id]);
        app('App\Http\Controllers\TemplateFieldController')->store($request);

        //create template 3
        $request = new \Illuminate\Http\Request();
        $template_doc = TemplateDoc::where('name', 'Предоставление ЗУ в черте населенного пункта')->first();
        $request->replace(['template_state' => 1, 'table_name' => 'p5_vipiska', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role4->id, 'order' => 4, 'to_citizen' => 1]);
        app('App\Http\Controllers\TemplateController')->store($request);
    }

    public function create_u4astok_v_nas_punkte_2(){
        //Предоставление земельного участка для строительства объекта в черте населенного пункта(этап 2)
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
        //Предоставление земельного участка для строительства объекта в черте населенного пункта
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
        $template = Template::where('table_name', 'p8_shema_i_zaklu4')->first();
        $request->replace(['fieldName' => 'shema_i_zaklu4', 'labelName' => 'Схема и Заключение', 'inputItem' => 2, 'insertItem' => 1, 'temp_id' => $template->id]);
        app('App\Http\Controllers\TemplateFieldController')->store($request);
        //create template 2
        $request = new \Illuminate\Http\Request();
        $request->replace(['template_state' => 1, 'table_name' => 'p8_zaklu4', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role2->id, 'order' => 2, 'to_citizen' => 0]);
        app('App\Http\Controllers\TemplateController')->store($request);
        //add template field
        $request = new \Illuminate\Http\Request();
        $template = Template::where('table_name', 'p8_zaklu4')->first();
        $request->replace(['fieldName' => 'zaklu4', 'labelName' => 'Заключение', 'inputItem' => 2, 'insertItem' => 1, 'temp_id' => $template->id]);
        app('App\Http\Controllers\TemplateFieldController')->store($request);
        //create template 3
        $request = new \Illuminate\Http\Request();
        $template_doc = TemplateDoc::where('name', 'Шаблон определение делимости')->first();
        $request->replace(['template_state' => 1, 'table_name' => 'p8_pismo', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role3->id, 'order' => 3, 'to_citizen' => 1]);
        app('App\Http\Controllers\TemplateController')->store($request);
        $template = Template::where('table_name', 'p8_pismo')->first();
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
        //Приобретение прав на земельные участки которые находятся в государственной собственности не требующее проведения торгов
        $process = Process::where('name', 'Приобретение прав на земельные участки которые находятся в государственной собственности не требующее проведения торгов')->first();
        //org name
        $org = CityManagement::where('name', 'Управление архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->main_organization_id = $org->id;
        $process->need_map = 1;
        $process->save();
        //create process application table
        $request = new \Illuminate\Http\Request();

        $request->replace(['fields' => ['region', 'first_name', 'middle_name', 'sur_name', 'iin', 'bin', 'telephone', 'applicant_address', 'object_address', 'pravo_ru', 'area', 'dictionary_purpose', 'zakaz4ik_drugoi', 'zakaz4ik_fiz_ur', 'iin_zakaz4ika', 'name_fiz_zakaz4ika', 'bin_zakaz4ika', 'name_ur_zakaz4ika', 'cadastral_number', 'shema_isprash_u4astka']]);
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
        $template = Template::where('table_name', 'p7_files_apo')->first();
        $request->replace(['fieldName' => 'files_apo', 'labelName' => 'Файлы', 'inputItem' => 2, 'insertItem' => 1, 'temp_id' => $template->id]);
        app('App\Http\Controllers\TemplateFieldController')->store($request);
        
        //create template
        $request = new \Illuminate\Http\Request();
        $template_doc = TemplateDoc::where('name', 'Без шаблона')->first();
        $request->replace(['template_state' => 1, 'table_name' => 'p7_files_monitoring', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role3->id, 'order' => 3, 'to_citizen' => 1]);
        app('App\Http\Controllers\TemplateController')->store($request);
        
        //add template field
        $request = new \Illuminate\Http\Request();
        $template = Template::where('table_name', 'p7_files_monitoring')->first();
        $request->replace(['fieldName' => 'files_monitoring', 'labelName' => 'Файлы', 'inputItem' => 2, 'insertItem' => 1, 'temp_id' => $template->id]);
        app('App\Http\Controllers\TemplateFieldController')->store($request);
        
        //final doc template
        $request = new \Illuminate\Http\Request();
        $template_doc = TemplateDoc::where('name', 'Шаблон 1 часть приобретение прав на ЗУ')->first();
        $request->replace(['template_state' => 1, 'table_name' => 'p7_vypiska_protokola', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role5->id, 'order' => 5, 'to_citizen' => 1]);
        app('App\Http\Controllers\TemplateController')->store($request);
    }

    public function create_bez_torgov2(){
        //Приобретение прав на земельные участки которые находятся в государственной собственности не требующее проведения торгов(этап 2)
        $process = Process::where('name', 'Приобретение прав на земельные участки которые находятся в государственной собственности не требующее проведения торгов(этап 2)')->first();
        //org name
        $org = CityManagement::where('name', 'Управление архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->main_organization_id = $org->id;
        $process->need_map = 0;
        $process->save();
        //create process application table
        $request = new \Illuminate\Http\Request();

        $request->replace(['fields' => ['region', 'first_name', 'middle_name', 'sur_name', 'iin', 'telephone', 'applicant_address', 'object_address', 'pravo_ru', 'area', 'dictionary_purpose', 'zakaz4ik_drugoi', 'zakaz4ik_fiz_ur', 'iin_zakaz4ika', 'name_fiz_zakaz4ika', 'bin_zakaz4ika', 'name_ur_zakaz4ika', 'cadastral_number', 'vypiska_protokola']]);
        app('App\Http\Controllers\ProcessController')->createProcessTable($request, $process);
        //add process roles
        $role1 = Role::where('name', 'Руководитель отдела организации работы земельной комиссии')->first();
        $process->roles()->attach($role1->id, [
            'can_reject' => 1,
            'can_send_to_revision' => 0,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 1
        ]);
        //'parent_role_id' => $request->parent_role_id,
        $role2 = Role::where('name', 'Специалист отдела земельного кадастра')->first();
        $process->roles()->attach($role2->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 1,
            'order' => 2
        ]);
        $role3 = Role::where('name', 'Руководитель отдела земельного кадастра')->first();
        $process->roles()->attach($role3->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 3
        ]);
        $role4 = Role::where('name', 'Специалист отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель')->first();
        $process->roles()->attach($role4->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 4
        ]);
        $role5 = Role::where('name', 'Руководитель отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель')->first();
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
        
        $request = new \Illuminate\Http\Request();
        $template_doc = TemplateDoc::where('name', 'Шаблон 2 часть приобретение прав на ЗУ')->first();
        $request->replace(['template_state' => 1, 'table_name' => 'p17_vypiska', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role1->id, 'order' => 1, 'to_citizen' => 1]);
        app('App\Http\Controllers\TemplateController')->store($request);

        //create template
        $request = new \Illuminate\Http\Request();
        $template_doc = TemplateDoc::where('name', 'Без шаблона')->first();
        $request->replace(['template_state' => 1, 'table_name' => 'p17_agreement', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role4->id, 'order' => 4, 'to_citizen' => 1]);
        app('App\Http\Controllers\TemplateController')->store($request);
        
        //add template field
        $request = new \Illuminate\Http\Request();
        $template = Template::where('table_name', 'p17_agreement')->first();
        $request->replace(['fieldName' => 'agreement', 'labelName' => 'Договор', 'inputItem' => 2, 'insertItem' => 1, 'temp_id' => $template->id]);
        app('App\Http\Controllers\TemplateFieldController')->store($request);
        
    }
    
    public function create_formirovanie_zu(){
        //Утверждение землеустроительных проектов по формированию земельных участков
        $process = Process::where('name', 'Утверждение землеустроительных проектов по формированию земельных участков')->first();
        //org name
        $org = CityManagement::where('name', 'Управление архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->main_organization_id = $org->id;
        $process->need_map = 1;
        $process->save();
        //create process application table
        $request = new \Illuminate\Http\Request();

        $request->replace(['fields' => ['first_name', 'middle_name', 'sur_name', 'iin', 'telephone', 'applicant_address', 'object_address', 'area', 'region', 'dictionary_purpose', 'zakaz4ik_drugoi', 'zakaz4ik_fiz_ur', 'iin_zakaz4ika', 'name_fiz_zakaz4ika', 'bin_zakaz4ika', 'name_ur_zakaz4ika', 'cadastral_number']]);
        app('App\Http\Controllers\ProcessController')->createProcessTable($request, $process);
        //add process roles
        $role1 = Role::where('name', 'Специалист отдела земельного кадастра')->first();
        $process->roles()->attach($role1->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 0,
            'can_ecp_sign' => 0,
            'can_motiv_otkaz' => 1,
            'order' => 1
        ]);
        //'parent_role_id' => $request->parent_role_id,
        $role2 = Role::where('name', 'Руководитель отдела земельного кадастра')->first();
        $process->roles()->attach($role2->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 2
        ]);
        $role3 = Role::where('name', 'Заместитель руководителя управления архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->roles()->attach($role3->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 3
        ]);

        //final doc template
        $request = new \Illuminate\Http\Request();
        $template_doc = TemplateDoc::where('name', 'Шаблон утверждение зем проекта')->first();
        $request->replace(['template_state' => 1, 'table_name' => 'p1_utverjdenie_zem_proekta', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role1->id, 'order' => 1, 'to_citizen' => 1]);
        app('App\Http\Controllers\TemplateController')->store($request);

        //add template field
        $request = new \Illuminate\Http\Request();
        $template = Template::where('table_name', 'p1_utverjdenie_zem_proekta')->first();
        $request->replace(['fieldName' => 'area_nedelimyi', 'labelName' => 'Доля площади (неделимый)', 'inputItem' => 1, 'insertItem' => 1, 'temp_id' => $template->id]);
        app('App\Http\Controllers\TemplateFieldController')->store($request);

    }

    public function create_provedenie_izyskatelskih(){
        //Выдача разрешения на использование земельного участка для изыскательских работ
        $process = Process::where('name', 'Выдача разрешения на использование земельного участка для изыскательских работ')->first();
        //org name
        $org = CityManagement::where('name', 'Управление архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->main_organization_id = $org->id;
        $process->need_map = 1;
        $process->save();
        //create process application table
        $request = new \Illuminate\Http\Request();

        $request->replace(['fields' => ['first_name', 'middle_name', 'sur_name', 'iin', 'bin', 'telephone', 'applicant_address', 'object_address', 'pravo_ru', 'area', 'dictionary_purpose', 'zakaz4ik_drugoi', 'zakaz4ik_fiz_ur', 'iin_zakaz4ika', 'name_fiz_zakaz4ika', 'bin_zakaz4ika', 'name_ur_zakaz4ika', 'cadastral_number']]);
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
            'can_send_to_revision' => 0,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 1,
            'order' => 2
        ]);
        $role3 = Role::where('name', 'Руководитель отдела мониторинга ТОО "Астанагорархитектура"')->first();
        $process->roles()->attach($role3->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 0,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 1,
            'order' => 3
        ]);
        $role4 = Role::where('name', 'Заместитель директора ТОО "Астанагорархитектура"')->first();
        $process->roles()->attach($role4->id, [
            'can_reject' => 1,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 4
        ]);
        $role5 = Role::where('name', 'Специалист отдела выдачи разрешительных документов на реконструкцию, градостроительного кадастра и учета введенных в эксплуатацию объектов, договоров долевого участия')->first();
        $process->roles()->attach($role5->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 0,
            'can_ecp_sign' => 0,
            'can_motiv_otkaz' => 1,
            'order' => 5
        ]);
        $role6 = Role::where('name', 'Руководитель отдела выдачи разрешительных документов на реконструкцию, градостроительного кадастра и учета введенных в эксплуатацию объектов, договоров долевого участия')->first();
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
        $request->replace(['template_state' => 1, 'table_name' => 'p6_files_apo', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role2->id, 'order' => 2, 'to_citizen' => 1]);
        app('App\Http\Controllers\TemplateController')->store($request);
        
        //add template field
        $request = new \Illuminate\Http\Request();
        $template = Template::where('table_name', 'p6_files_apo')->first();
        $request->replace(['fieldName' => 'shema_apo', 'labelName' => 'Схема', 'inputItem' => 2, 'insertItem' => 1, 'temp_id' => $template->id]);
        app('App\Http\Controllers\TemplateFieldController')->store($request);
    
        //add template field
        $request = new \Illuminate\Http\Request();
        $template = Template::where('table_name', 'p6_files_apo')->first();
        $request->replace(['fieldName' => 'spravka_apo', 'labelName' => 'Справка', 'inputItem' => 2, 'insertItem' => 1, 'temp_id' => $template->id]);
        app('App\Http\Controllers\TemplateFieldController')->store($request);

        //create template
        $request = new \Illuminate\Http\Request();
        $template_doc = TemplateDoc::where('name', 'Без шаблона')->first();
        $request->replace(['template_state' => 1, 'table_name' => 'p6_files_monitoring', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role3->id, 'order' => 3, 'to_citizen' => 1]);
        app('App\Http\Controllers\TemplateController')->store($request);
        
        //add template field
        $request = new \Illuminate\Http\Request();
        $template = Template::where('table_name', 'p6_files_monitoring')->first();
        $request->replace(['fieldName' => 'shema_monitoring', 'labelName' => 'Схема', 'inputItem' => 2, 'insertItem' => 1, 'temp_id' => $template->id]);
        app('App\Http\Controllers\TemplateFieldController')->store($request);

        //add template field
        $request = new \Illuminate\Http\Request();
        $template = Template::where('table_name', 'p6_files_monitoring')->first();
        $request->replace(['fieldName' => 'spravka_monitoring', 'labelName' => 'Справка', 'inputItem' => 2, 'insertItem' => 1, 'temp_id' => $template->id]);
        app('App\Http\Controllers\TemplateFieldController')->store($request);
        
        //final doc template
        $request = new \Illuminate\Http\Request();
        $template_doc = TemplateDoc::where('name', 'Шаблон изыскательных работ')->first();
        $request->replace(['template_state' => 1, 'table_name' => 'p6_izyskatelskih_rabot', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role5->id, 'order' => 5, 'to_citizen' => 1]);
        app('App\Http\Controllers\TemplateController')->store($request);
    }

    public function create_privle4enie_dolwikov(){
        //Выдача разрешения на привлечение денег дольщиков
        $process = Process::where('name', 'Выдача разрешения на привлечение денег дольщиков')->first();
        //org name
        $org = CityManagement::where('name', 'Управление архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->main_organization_id = $org->id;
        $process->need_map = 1;
        $process->save();
        //create process application table
        $request = new \Illuminate\Http\Request();

        $request->replace(['fields' => ['first_name', 'middle_name', 'sur_name', 'iin', 'bin', 'telephone', 'applicant_address', 'object_address', 'pravo_ru', 'area', 'dictionary_purpose', 'zakaz4ik_drugoi', 'zakaz4ik_fiz_ur', 'iin_zakaz4ika', 'name_fiz_zakaz4ika', 'bin_zakaz4ika', 'name_ur_zakaz4ika', 'cadastral_number']]);
        app('App\Http\Controllers\ProcessController')->createProcessTable($request, $process);
        //add process roles
        $role1 = Role::where('name', 'Специалист отдела выдачи разрешительных документов на реконструкцию, градостроительного кадастра и учета введенных в эксплуатацию объектов, договоров долевого участия')->first();
        $process->roles()->attach($role1->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 0,
            'can_ecp_sign' => 0,
            'can_motiv_otkaz' => 1,
            'order' => 1
        ]);
        //'parent_role_id' => $request->parent_role_id,
        $role2 = Role::where('name', 'Гос Правовой отдел акимата')->first();
        $process->roles()->attach($role2->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 0,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 2
        ]);
        $role3 = Role::where('name', 'Заместитель руководителя управления архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->roles()->attach($role3->id, [
            'can_reject' => 1,
            'can_send_to_revision' => 0,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 3
        ]);
        $role4 = Role::where('name', 'Руководитель управления архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->roles()->attach($role4->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 4
        ]);
        $role5 = Role::where('name', 'Заместитель акима')->first();
        $process->roles()->attach($role5->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 0,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 5
        ]);

        //create template 1
        $request = new \Illuminate\Http\Request();
        $template_doc = TemplateDoc::where('name', 'Без шаблона')->first();
        $request->replace(['template_state' => 1, 'table_name' => 'p10_razrewenie', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role1->id, 'order' => 1, 'to_citizen' => 0]);
        app('App\Http\Controllers\TemplateController')->store($request);
        //add template field
        $request = new \Illuminate\Http\Request();
        $template = Template::where('table_name', 'p10_razrewenie')->first();
        $request->replace(['fieldName' => 'razrewenie', 'labelName' => 'Разрешение', 'inputItem' => 2, 'insertItem' => 1, 'temp_id' => $template->id]);
        app('App\Http\Controllers\TemplateFieldController')->store($request);
    }

    public function create_postutilizacia_obektov(){
        //Выдача решения на проведение комплекса работ по постутилизации объектов
        $process = Process::where('name', 'Выдача решения на проведение комплекса работ по постутилизации объектов')->first();
        //org name
        $org = CityManagement::where('name', 'Управление архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->main_organization_id = $org->id;
        $process->need_map = 1;
        $process->save();
        //create process application table
        $request = new \Illuminate\Http\Request();

        $request->replace(['fields' => ['first_name', 'middle_name', 'sur_name', 'iin', 'bin', 'telephone', 'applicant_address', 'object_address', 'pravo_ru', 'area', 'dictionary_purpose', 'zakaz4ik_drugoi', 'zakaz4ik_fiz_ur', 'iin_zakaz4ika', 'name_fiz_zakaz4ika', 'bin_zakaz4ika', 'name_ur_zakaz4ika', 'cadastral_number']]);
        app('App\Http\Controllers\ProcessController')->createProcessTable($request, $process);
        //add process roles
        $role1 = Role::where('name', 'Руководитель управления архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->roles()->attach($role1->id, [
            'can_reject' => 1,
            'can_send_to_revision' => 0,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 1
        ]);
        //'parent_role_id' => $request->parent_role_id,
        $role2 = Role::where('name', 'Специалист отдела выдачи разрешительных документов на реконструкцию, градостроительного кадастра и учета введенных в эксплуатацию объектов, договоров долевого участия')->first();
        $process->roles()->attach($role2->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 0,
            'can_ecp_sign' => 0,
            'can_motiv_otkaz' => 1,
            'order' => 2
        ]);
        $role3 = Role::where('name', 'Руководитель отдела выдачи разрешительных документов на реконструкцию, градостроительного кадастра и учета введенных в эксплуатацию объектов, договоров долевого участия')->first();
        $process->roles()->attach($role3->id, [
            'can_reject' => 1,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 3
        ]);
        $role4 = Role::where('name', 'Заместитель руководителя управления архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->roles()->attach($role4->id, [
            'can_reject' => 1,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 4
        ]);
        $role5 = Role::where('name', 'Руководитель управления архитектуры, градостроительства и земельных отношений города Нур-Султан')->first();
        $process->roles()->attach($role5->id, [
            'can_reject' => 0,
            'can_send_to_revision' => 1,
            'can_ecp_sign' => 1,
            'can_motiv_otkaz' => 0,
            'order' => 5
        ]);

        //final doc template
        $request = new \Illuminate\Http\Request();
        $template_doc = TemplateDoc::where('name', 'Шаблон постутилизации')->first();
        $request->replace(['template_state' => 1, 'table_name' => 'p15_postutilizaciya', 'process_id' => $process->id, 'template_doc_id' => $template_doc->id, 'role_id' => $role5->id, 'order' => 2, 'to_citizen' => 1]);
        app('App\Http\Controllers\TemplateController')->store($request);
    }
}