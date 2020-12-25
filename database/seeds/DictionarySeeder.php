<?php

use Illuminate\Database\Seeder;

class DictionarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dictionaries')->insert([
            [
                'name' => 'name',
                'label_name' => 'Имя',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'surname',
                'label_name' => 'Фамилия',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'address',
                'label_name' => 'Адрес',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'attachment',
                'label_name' => 'Загрузите Файл',
                'input_type_id' => 2,
                'insert_type_id' => 1
            ],

        ]);
    }
}
