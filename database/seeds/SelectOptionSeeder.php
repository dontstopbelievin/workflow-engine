<?php

use Illuminate\Database\Seeder;

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
                'name' => 'НЕТ' //1
            ],
            [
                'name' => 'Астана ГорАрхитектура' //1
            ],
            [
                'name' => 'Управление Архитектуры' //1
            ],
            [
                'name' => 'Коммунальные службы' //1
            ],
        ]);
    }
}
