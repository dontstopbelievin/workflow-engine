<?php

use Illuminate\Database\Seeder;

class InsertTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('insert_types')->insert([
            [
                'name' => 'string' //1
            ],
            [
                'name' => 'text' //2
            ],
            [
                'name' => 'date' //3
            ],
            [
                'name' => 'float' //4
            ],
            [
                'name' => 'integer' //5
            ],
            [
                'name' => 'json' //6
            ],
            [
                'name' => 'boolean' //7
            ],
            
        ]);
    }
}
