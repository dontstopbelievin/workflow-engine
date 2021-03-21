<?php

use Illuminate\Database\Seeder;
use App\CityManagement;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('roles')->insert([
            [
                'city_management_id' => 9,
                'name' => 'Заявитель', // 1
                'sign_with_ecp' => 0,
            ],
            [
                'city_management_id' => 1,
                'name' => 'Специалист отдела выдачи разрешительных документов на реконструкцию, градостроительного кадастра и учета введенных в эксплуатацию объектов, договоров долевого участия', // 2
                'sign_with_ecp' => 0,
            ],
            [
                'city_management_id' => 1,
                'name' => 'Специалист отдела земельного кадастра', // 3
                'sign_with_ecp' => 0,
            ],
            [
                'city_management_id' => 8,
                'name' => 'Специалист НАО', // 4
                'sign_with_ecp' => 0,
            ],
            [
                'city_management_id' => 7,
                'name' => 'Специалист Газ-Кызмета', // 5
                'sign_with_ecp' => 0,
            ],
            [
                'city_management_id' => 3,
                'name' => 'Специалист АРЭК', // 6
                'sign_with_ecp' => 0,
            ],
            [
                'city_management_id' => 4,
                'name' => 'Специалист Теплотранзит', // 7
                'sign_with_ecp' => 0,
            ],
            [
                'city_management_id' => 6,
                'name' => 'Специалист Астана Су ', // 8
                'sign_with_ecp' => 0,
            ],
            [
                'city_management_id' => 1, //9
                'name' => 'Специалист отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель', // 8
                'sign_with_ecp' => 0,
            ],
            [
                'city_management_id' => 1, // 10
                'name' => 'Руководитель отдела выдачи разрешительных документов на реконструкцию, градостроительного кадастра и учета введенных в эксплуатацию объектов, договоров долевого участия', // 9
                'sign_with_ecp' => 1,
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела рассмотрения эскизных проектов и наружной рекламы', // 11
                'sign_with_ecp' => 1,
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела городского планирования по району «Алматы»', // 12
                'sign_with_ecp' => 1,
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела городского планирования по району «Байқоңыр»', // 13
                'sign_with_ecp' => 1,
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела городского планирования по району «Есиль»', // 14
                'sign_with_ecp' => 1,
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела городского планирования по району «Сарыарка»', // 15
                'sign_with_ecp' => 1,
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела градостроительного планирования, развития города Нур-Султан и цифровизации госудаственных услуг', // 16
                'sign_with_ecp' => 1,
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела организации работы земельной комиссии', // 17
                'sign_with_ecp' => 1,
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель', // 18
                'sign_with_ecp' => 1,
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела земельного кадастра', // 19
                'sign_with_ecp' => 1,
            ],
            [
                'city_management_id' => 2,
                'name' => 'Руководитель архитектурно-планировочного отдела', // 20
                'sign_with_ecp' => 1,
            ],
            [
                'city_management_id' => 2,
                'name' => 'Руководитель отдела подготовки и выдачи исходных данных', // 21
                'sign_with_ecp' => 1,
            ],
            [
                'city_management_id' => 2,
                'name' => 'Руководитель отдела мониторинга ТОО "Астанагорархитектура"', // 22
                'sign_with_ecp' => 1,
            ],
            [
                'city_management_id' => 2,
                'name' => 'Заместитель директора ТОО "Астанагорархитектура"', // 23
                'sign_with_ecp' => 1,
            ],
            [
                'city_management_id' => 1,
                'name' => 'Заместитель руководителя управления архитектуры, градостроительства и земельных отношений города Нур-Султан', // 24
                'sign_with_ecp' => 1,
            ],
            [
                'city_management_id' => 2,
                'name' => 'Директор ТОО "Астанагорархитектура"', // 25
                'sign_with_ecp' => 1,
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель управления архитектуры, градостроительства и земельных отношений города Нур-Султан', // 26
                'sign_with_ecp' => 1,
            ],
            [
                'city_management_id' => 1,
                'name' => 'В отпуске', // 27
                'sign_with_ecp' => 0,
            ],
            [
                'city_management_id' => 1,
                'name' => 'Уволен', // 28
                'sign_with_ecp' => 0,
            ],
            [
                'city_management_id' => 1,
                'name' => 'Специалист Айкала', // 29
                'sign_with_ecp' => 0,
            ],
            [
                'city_management_id' => 1,
                'name' => 'Специалист Акимата', // 30
                'sign_with_ecp' => 0,
            ],
            [
                'city_management_id' => 1,
                'name' => 'Канцелярия Акимата', // 31
                'sign_with_ecp' => 0,
            ],
            [
                'city_management_id' => 1,
                'name' => 'Гос Правовой отдел акимата', // 32
                'sign_with_ecp' => 0,
            ],
            [
                'city_management_id' => 1,
                'name' => 'Заместитель акима', // 33
                'sign_with_ecp' => 0,
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела городского планирования',
                'sign_with_ecp' => 1,
            ],
        ]);
    }
}
