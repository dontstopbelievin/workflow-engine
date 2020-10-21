<?php

use Illuminate\Database\Seeder;
use App\CityManagement;

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
            ],
            [
                'city_management_id' => 1,
                'name' => 'Специалист отдела выдачи разрешительных документов на реконструкцию, градостроительного кадастра и учета введенных в эксплуатацию объектов, договоров долевого участия', // 2
            ],
            [
                'city_management_id' => 1,
                'name' => 'Специалист отдела земельного кадастра', // 3
            ],
            [
                'city_management_id' => 8,
                'name' => 'Специалист НАО', // 4
            ],
            [
                'city_management_id' => 7,
                'name' => 'Специалист Газ-Кызмета', // 5
            ],
            [
                'city_management_id' => 3,
                'name' => 'Специалист АРЭК', // 6
            ],
            [
                'city_management_id' => 4,
                'name' => 'Специалист Теплотранзит', // 7
            ],
            [
                'city_management_id' => 6,
                'name' => 'Специалист Астана Су ', // 8
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела выдачи разрешительных документов на реконструкцию, градостроительного кадастра и учета введенных в эксплуатацию объектов, договоров долевого участия', // 9
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела рассмотрения эскизных проектов и наружной рекламы', // 10
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела городского планирования по району «Алматы»', // 11
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела городского планирования по району «Байқоңыр»', // 12
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела городского планирования по району «Есиль»', // 13
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела городского планирования по району «Сарыарка»', // 14
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела градостроительного планирования, развития города Нур-Султан и цифровизации госудаственных услуг', // 15
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела организации работы земельной комиссии', // 16
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель', // 17
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела земельного кадастра', // 18
            ],
            [
                'city_management_id' => 2,
                'name' => 'Руководитель архитектурно-планировочного отдела', // 19
            ],
            [
                'city_management_id' => 2,
                'name' => 'Руководитель отдела подготовки и выдачи исходных данных', // 20
            ],
            [
                'city_management_id' => 2,
                'name' => 'Руководитель отдела мониторинга', // 21
            ],
            [
                'city_management_id' => 2,
                'name' => 'Заместитель директора городской архитектуры', // 22
            ],
            [
                'city_management_id' => 1,
                'name' => 'Заместитель руководителя управления', // 23
            ],
            [
                'city_management_id' => 2,
                'name' => 'Директор городской архитектуры', // 24
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель управления', // 25
            ],

        ]);
    }
}
