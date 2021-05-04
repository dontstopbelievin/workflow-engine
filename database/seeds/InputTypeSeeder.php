<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InputTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('input_types')->insert([
            [
                'name' => 'text' //1
            ],
            [
                'name' => 'file' //2
            ],
            [
                'name' => 'select' //3
            ],
            [
                'name' => 'textarea' //4
            ],
            [
                'name' => 'hidden' //5
            ],
            [
                'name' => 'radio_button' //6
            ],
            [
                'name' => 'checkbox' //7
            ],
        ]);
    }
}
