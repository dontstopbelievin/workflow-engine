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
                'pdf_path' => 'PDFtemplates.celevoe_naznachenie' //1
            ],
            [
                'name' => 'Шаблон изыскательных работ', 
                'pdf_path' => 'PDFtemplates.proektno_izyskatelnyi' //1
            ],
            [
                'name' => 'Шаблон утверждение зем проекта', 
                'pdf_path' => 'PDFtemplates.utverjdenie_zem_proekta' //1
            ],
            [
                'name' => 'Шаблон эскизного проекта', 
                'pdf_path' => 'PDFtemplates.sketch' //1
            ],
            [
                'name' => 'Шаблон постутилизации', 
                'pdf_path' => 'PDFtemplates.postutilizaciya' //1
            ],
            [
                'name' => 'Шаблон продажа ЗУ единовременно', 
                'pdf_path' => 'PDFtemplates.prodaja_zu_edinovremenno' //1
            ],
            [
                'name' => 'Шаблон постановка в очередь на ЗУ', 
                'pdf_path' => 'PDFtemplates.postanovka_poluchenie_zu' //1
            ],
            [
                'name' => 'Шаблон определение делимости', 
                'pdf_path' => 'PDFtemplates.delimost_nedilimost' //1
            ],
            [
                'name' => 'Шаблон 1 часть приобретение прав на ЗУ', 
                'pdf_path' => 'PDFtemplates.1_priobretenie_prav_na_zu' //1
            ],
            [
                'name' => 'Шаблон 2 часть приобретение прав на ЗУ', 
                'pdf_path' => 'PDFtemplates.2_priobretenie_prav_na_zu' //1
            ],
            [
                'name' => 'Предоставление ЗУ в черте населенного пункта', 
                'pdf_path' => 'PDFtemplates.predostavlenie_v_cherte.blade' //1
            ],
            [
                'name' => 'Без шаблона', 
                'pdf_path' => 'PDFtemplates.empty' //1
            ],
        ]);
    }
}
