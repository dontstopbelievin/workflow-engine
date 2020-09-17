<?php

use Illuminate\Database\Seeder;

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
                'name' => 'file' //1
            ],
            [
                'name' => 'select' //1
            ],
            
        ]);
    }
}
