<?php

use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([
            [
                'name' => 'egkn_receive_status',
                'label' => 'ЕГКН получить статус',
                'sync' => 1,
            ],
            [
                'name' => 'egkn_receive_order',
                'label' => 'ЕГКН универсальный сервис по приему заказа',
                'sync' => 0,
            ],
            [
                'name' => 'geoportal_egkn_receive_layer',
                'label' => 'ЕГКН актуализация пространственных данных',
                'sync' => 1,
            ],
            [
                'name' => 'egkn_geoportal_actualization',
                'label' => 'ЕГКН актуализация данных',
                'sync' => 1,
            ],
            [
                'name' => 'eds_temp_files',
                'label' => 'Единое Хранилище Электронных Данных',
                'sync' => 1,
            ],
            [
                'name' => 'geoportal_pep_async',
                'label' => 'Сервис приема заявлений на получение постановления МИО и акта выбора',
                'sync' => 0,
            ],
            [
                'name' => 'ais_gzk_get_data',
                'label' => 'АИС ГЗК предоставление пространственных данных',
                'sync' => 1,
            ],
            [
                'name' => 'ais_gzk_get_relevance',
                'label' => 'АИС ГЗК данные о ЗУ, собственники',
                'sync' => 1,
            ],
        ]);
    }
}
