<?php

use Illuminate\Database\Seeder;

class RoleStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//1-odobril 2-otkazal 3-podpisal 4-otrpavelno
        DB::table('role_statuses')->insert([
        	[
                'status_id' => 4,
                'role_name' => 'Заявитель',
                'string' => 'Отправлено заявителю',
            ],
            [
                'status_id' => 1,
                'role_name' => 'Специалист Айкала',
                'string' => 'Одобрено специалистом Айкала',
            ],
            [
                'status_id' => 2,
                'role_name' => 'Специалист Айкала',
                'string' => 'Отклонено специалистом Айкала',
            ],
            [
                'status_id' => 3,
                'role_name' => 'Специалист Айкала',
                'string' => 'Подписано специалистом Айкала',
            ],
            [
                'status_id' => 4,
                'role_name' => 'Специалист Айкала',
                'string' => 'Отправлено специалисту Айкала',
            ],
            [
                'status_id' => 1,
                'role_name' => 'Канцелярия Акимата',
                'string' => 'Одобрено канцелярием Акимата',
            ],
            [
                'status_id' => 2,
                'role_name' => 'Канцелярия Акимата',
                'string' => 'Отклонено канцелярием Акимата',
            ],
            [
                'status_id' => 3,
                'role_name' => 'Канцелярия Акимата',
                'string' => 'Подписано канцелярием Акимата',
            ],
            [
                'status_id' => 4,
                'role_name' => 'Канцелярия Акимата',
                'string' => 'Отправлено канцелярию	 Акимата',
            ],
            [
                'status_id' => 1,
                'role_name' => 'Руководитель управления архитектуры, градостроительства и земельных отношений города Нур-Султан',
                'string' => 'Одобрено руководителем управления архитектуры, градостроительства и земельных отношений города Нур-Султан',
            ],
            [
                'status_id' => 2,
                'role_name' => 'Руководитель управления архитектуры, градостроительства и земельных отношений города Нур-Султан',
                'string' => 'Отклонено руководителем управления архитектуры, градостроительства и земельных отношений города Нур-Султан',
            ],
            [
                'status_id' => 3,
                'role_name' => 'Руководитель управления архитектуры, градостроительства и земельных отношений города Нур-Султан',
                'string' => 'Подписано руководителем управления архитектуры, градостроительства и земельных отношений города Нур-Султан',
            ],
            [
                'status_id' => 4,
                'role_name' => 'Руководитель управления архитектуры, градостроительства и земельных отношений города Нур-Султан',
                'string' => 'Отправлено руководителю управления архитектуры, градостроительства и земельных отношений города Нур-Султан',
            ],
            [
                'status_id' => 1,
                'role_name' => 'Специалист отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель',
                'string' => 'Одобрено специалистом отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель',
            ],
            [
                'status_id' => 2,
                'role_name' => 'Специалист отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель',
                'string' => 'Отклонено специалистом отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель',
            ],
            [
                'status_id' => 3,
                'role_name' => 'Специалист отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель',
                'string' => 'Подписано специалистом отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель',
            ],
            [
                'status_id' => 4,
                'role_name' => 'Специалист отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель',
                'string' => 'Отправлено специалисту отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель',
            ],
            [
                'status_id' => 1,
                'role_name' => 'Руководитель отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель',
                'string' => 'Одобрено руководителем отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель',
            ],
            [
                'status_id' => 2,
                'role_name' => 'Руководитель отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель',
                'string' => 'Отклонено руководителем отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель',
            ],
            [
                'status_id' => 3,
                'role_name' => 'Руководитель отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель',
                'string' => 'Подписано руководителем отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель',
            ],
            [
                'status_id' => 4,
                'role_name' => 'Руководитель отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель',
                'string' => 'Отправлено руководителю отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель',
            ],
            [
                'status_id' => 1,
                'role_name' => 'Заместитель руководителя управления архитектуры, градостроительства и земельных отношений города Нур-Султан',
                'string' => 'Одобрено заместителем руководителя управления архитектуры, градостроительства и земельных отношений города Нур-Султан',
            ],
            [
                'status_id' => 2,
                'role_name' => 'Заместитель руководителя управления архитектуры, градостроительства и земельных отношений города Нур-Султан',
                'string' => 'Отклонено заместителем руководителя управления архитектуры, градостроительства и земельных отношений города Нур-Султан',
            ],
            [
                'status_id' => 3,
                'role_name' => 'Заместитель руководителя управления архитектуры, градостроительства и земельных отношений города Нур-Султан',
                'string' => 'Подписано заместителем руководителя управления архитектуры, градостроительства и земельных отношений города Нур-Султан',
            ],
            [
                'status_id' => 4,
                'role_name' => 'Заместитель руководителя управления архитектуры, градостроительства и земельных отношений города Нур-Султан',
                'string' => 'Отправлено заместителю руководителя управления архитектуры, градостроительства и земельных отношений города Нур-Султан',
            ],
        ]);
    }
}
