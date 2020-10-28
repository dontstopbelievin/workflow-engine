<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SelectOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('select_options')->insert([
            [
                'name' => 'ДА' //1
            ],
            [
                'name' => 'НЕТ' //2
            ],
            [
                'name' => 'Астана ГорАрхитектура' //3
            ],
            [
                'name' => 'Управление Архитектуры' //4
            ],
            [
                'name' => 'Коммунальные службы' //5
            ],
        ]);
    }
}
