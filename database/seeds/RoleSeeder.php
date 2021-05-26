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
                'name' => 'Специалист Астана Су', // 8
            ],
            [
                'city_management_id' => 1, //9
                'name' => 'Специалист отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель', // 8

            ],
            [
                'city_management_id' => 1, // 10
                'name' => 'Руководитель отдела выдачи разрешительных документов на реконструкцию, градостроительного кадастра и учета введенных в эксплуатацию объектов, договоров долевого участия', // 9

            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела рассмотрения эскизных проектов и наружной рекламы', // 11

            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела городского планирования по району «Алматы»', // 12

            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела городского планирования по району «Байқоңыр»', // 13

            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела городского планирования по району «Есиль»', // 14

            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела городского планирования по району «Сарыарка»', // 15

            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела градостроительного планирования, развития города Нур-Султан и цифровизации госудаственных услуг', // 16

            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела организации работы земельной комиссии', // 17

            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела заключения договоров и контроля за их использованием, подготовки решений об изъятии и резервировании земель', // 18

            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела земельного кадастра', // 19

            ],
            [
                'city_management_id' => 2,
                'name' => 'Руководитель архитектурно-планировочного отдела', // 20

            ],
            [
                'city_management_id' => 2,
                'name' => 'Руководитель отдела подготовки и выдачи исходных данных', // 21

            ],
            [
                'city_management_id' => 2,
                'name' => 'Руководитель отдела мониторинга ТОО "Астанагорархитектура"', // 22

            ],
            [
                'city_management_id' => 2,
                'name' => 'Заместитель директора ТОО "Астанагорархитектура"', // 23

            ],
            [
                'city_management_id' => 1,
                'name' => 'Заместитель руководителя управления архитектуры, градостроительства и земельных отношений города Нур-Султан', // 24

            ],
            [
                'city_management_id' => 2,
                'name' => 'Директор ТОО "Астанагорархитектура"', // 25

            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель управления архитектуры, градостроительства и земельных отношений города Нур-Султан', // 26

            ],
            [
                'city_management_id' => 1,
                'name' => 'В отпуске', // 27

            ],
            [
                'city_management_id' => 1,
                'name' => 'Уволен', // 28

            ],
          ]);
          DB::table('roles')->insert([
            [
                'name' => 'ЕГКН получить статус',
                'service_label' => 'egkn_receive_status',
                'service_sync' => 1,
                'isRole' => 0,
            ],
            [
                'name' => 'ЕГКН универсальный сервис по приему заказа',
                'service_label' => 'egkn_receive_order',
                'service_sync' => 0,
                'isRole' => 0,
            ],
            [
                'name' => 'ЕГКН актуализация пространственных данных',
                'service_label' => 'geoportal_egkn_receive_layer',
                'service_sync' => 1,
                'isRole' => 0,
            ],
            [
                'name' => 'ЕГКН актуализация данных',
                'service_label' => 'egkn_geoportal_actualization',
                'service_sync' => 1,
                'isRole' => 0,
            ],
            [
                'name' => 'Единое Хранилище Электронных Данных',
                'service_label' => 'eds_temp_files',
                'service_sync' => 1,
                'isRole' => 0,
            ],
            [
                'name' => 'Сервис приема заявлений на получение постановления МИО и акта выбора',
                'service_label' => 'geoportal_pep_async',
                'service_sync' => 0,
                'isRole' => 0,
            ],
            [
                'name' => 'АИС ГЗК предоставление пространственных данных',
                'service_label' => 'ais_gzk_get_data',
                'service_sync' => 1,
                'isRole' => 0,
            ],
            [
                'name' => 'АИС ГЗК данные о ЗУ, собственники',
                'service_label' => 'ais_gzk_get_relevance',
                'service_sync' => 1,
                'isRole' => 0,
            ]
        ]);
        DB::table('roles')->insert([
            [
                'city_management_id' => 1,
                'name' => 'Специалист Айкала', // 29
            ],
            [
                'city_management_id' => 1,
                'name' => 'Специалист Акимата', // 30
            ],
            [
                'city_management_id' => 1,
                'name' => 'Канцелярия Акимата', // 31
            ],
            [
                'city_management_id' => 1,
                'name' => 'Гос Правовой отдел акимата', // 32
            ],
            [
                'city_management_id' => 1,
                'name' => 'Заместитель акима', // 33
            ],
            [
                'city_management_id' => 1,
                'name' => 'Руководитель отдела городского планирования',//34
            ],
            [
                'city_management_id' => 1,
                'name' => 'Отдел земельной комиссии', // 35
            ],
            [
                'city_management_id' => 1,
                'name' => 'Admin', // 36
            ],
        ]);
    }
}
