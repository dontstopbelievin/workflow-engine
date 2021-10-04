<?php

use Illuminate\Database\Seeder;

class FileCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('files_categories')->insert([
            [
                'name' => 'XML',
                'allowed_ext' => 'xml',
                'is_visible' => true,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'IMG',
                'allowed_ext' => 'jpg, png, jpeg',
                'is_visible' => true,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'DOC/DOCX',
                'allowed_ext' => 'doc, docx',
                'is_visible' => true,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'PDF',
                'allowed_ext' => 'pdf',
                'is_visible' => true,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'PPT',
                'allowed_ext' => 'ppt',
                'is_visible' => true,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'ARCHIVE',
                'allowed_ext' => 'zip, rar',
                'is_visible' => true,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
        ]);

    }
}
