<?php

use Illuminate\Database\Seeder;

class TemplateDocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('template_docs')->insert([
            [
                'name' => 'Шаблон целевого назначения', 
                'pdf_path' => 'resources\\views\\PDFtemplates\\celevoe_naznachenie' //1
            ],
            [
                'name' => 'Шаблон изыскательных работ', 
                'pdf_path' => 'resources\\views\\PDFtemplates\\proektno-izyskatelnyi' //1
            ],

        ]);
    }
}
