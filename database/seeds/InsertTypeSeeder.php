<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'name' => 'text' //1
            ],
            [
                'name' => 'date' //1
            ],
            [
                'name' => 'float' //1
            ],
            [
                'name' => 'integer' //1
            ],
            [
                'name' => 'json' //1
            ],
            [
                'name' => 'boolean' //1
            ],
            
        ]);
    }
}
