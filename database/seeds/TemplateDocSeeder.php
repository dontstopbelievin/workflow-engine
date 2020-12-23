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
                'pdf_path' => 'PDFtemplates\\celevoe_naznachenie' //1
            ],
            [
                'name' => 'Шаблон изыскательных работ', 
                'pdf_path' => 'PDFtemplates\\proektno-izyskatelnyi' //1
            ],
            [
                'name' => 'Шаблон утверждение зем проекта', 
                'pdf_path' => 'PDFtemplates\\utverjdenie_zem_proekta' //1
            ],
            [
                'name' => 'Шаблон эскизного проекта', 
                'pdf_path' => 'PDFtemplates\\sketch' //1
            ],
        ]);
    }
}
