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
                'name' => 'ТОО Астана Гор Архитектура' //1
            ],
            [
                'name' => 'Коммунальные Службы' //1
            ],

        ]);
    }
}
