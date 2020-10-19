<?php

use Illuminate\Database\Seeder;

class CityManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city_managements')->insert([
            [
                'name' => 'Управление Архитектуры' //1
            ],
            [
                'name' => 'ТОО "Астана Гор Архитектура"' //1
            ],
            [
                'name' => 'АО "Астана-РЭК"' //1
            ],
            [
                'name' => 'АО "Астана-Теплотранзит"' //1
            ],
            [
                'name' => 'АО "Казахтелеком"' //1
            ],
            [
                'name' => 'ГКП "Астана Су Арнасы"' //1
            ],
            [
                'name' => 'ТОО "Газ-Кызмет"' //1
            ],
            [
                'name' => 'НАО' //1
            ],

        ]);
    }
}
