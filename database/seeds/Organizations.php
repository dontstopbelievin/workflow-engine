<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Organizations extends Seeder
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
                'name' => 'Управлениеархитектуры, градостроительства и земельных отношений города Нур-Султан' //1
            ],
            [
                'name' => 'ТОО "Астанагорархитектура"' //2
            ],
            [
                'name' => 'АО "Астана-РЭК"' //3
            ],
            [
                'name' => 'АО "Астана-Теплотранзит"' //4
            ],
            [
                'name' => 'АО "Казахтелеком"' //5
            ],
            [
                'name' => 'ГКП "Астана Су Арнасы"' //6
            ],
            [
                'name' => 'ТОО "Газ-Кызмет"' //7
            ],
            [
                'name' => 'НАО' //8
            ],
            [
                'name' => 'Заявитель' //9
            ],

        ]);
    }
}
