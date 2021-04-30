<?php

use Illuminate\Database\Seeder;
use App\Process;

class ProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('processes')->insert([
            [
                'deadline' => 12,
                'name' => 'Утверждение землеустроительных проектов по формированию земельных участков',//1,
                'table_name' => 'p1_utverjdenie_zem_proekt_form_zu',
            ],
            [
                'deadline' => 12,
                'name' => 'Предоставление исходных материалов при разработке проектов строительства и реконструкции', //2
                'table_name' => 'p2_pred_isxod_mat_razrab_proekt_stroit_i_rek',
            ],
            [
                'deadline' => 15,
                'name' => 'Согласование эскизного проекта', //3
                'table_name' => 'p3_eskiz',
            ],
            [
                'deadline' => 8,
                'name' => 'Выдача выписки об учетной записи договора о долевом участии в жилищном строительства', //4
                'table_name' => 'p4_vipiska_dolev_u4ast_zhilish_stroi',
            ],
            [
                'deadline' => 9,
                'name' => 'Выдача решения на изменение целевого назначения земельного участка', //5
                'table_name' => 'p5_izmena_celevoe_zu',
            ],
            [
                'deadline' => 11,
                'name' => 'Выдача разрешения на использование земельного участка для изыскательских работ', //6
                'table_name' => 'p6_ispolzovan_iziskatel_rabot',
            ],
            [
                'deadline' => 12,
                'name' => 'Приобретение прав на земельные участки которые находятся в государственной собственности не требующее проведения торгов', //7
                'table_name' => 'p7_prib_prav_zu_v_gose',
            ],
            [
                'deadline' => 8,
                'name' => 'Определение делимости и неделимости земельных участков', //8
                'table_name' => 'p8_delimost',
            ],
            [
                'deadline' => 28,
                'name' => 'Предоставление земельного участка для строительства объекта в черте населенного пункта', //9
                'table_name' => 'p9_pred_zu_dlya_stroi_v_4erte',
            ],
            [
                'deadline' => 14,
                'name' => 'Выдача разрешения на привлечение денег дольщиков', //10
                'table_name' => 'p10_privle4enie_deneg_dolwikov',
            ],
            [
                'deadline' =>11,
                'name' => 'Продажа земельного участка в частную собственность единовременно либо в рассрочку', //11
                'table_name' => 'p11_prodaj_zu_edinov_ili_rassro4',
            ],
            [
                'deadline' => 11,
                'name' => 'Заключение договоров купли-продажи земельного участка', //12
                'table_name' => 'p12_dogovor_kupli_prodaj_zu',
            ],
            [
                'deadline' => 8,
                'name' => 'Заключение договоров аренды земельного участка', //13
                'table_name' => 'p13_dogovor_arendi_zu',
            ],
            [
                'deadline' => 12,
                'name' => 'Постановка на очередь на получение земельного участка', //14
                'table_name' => 'p14_postanov_na_o4ered_na_zu',
            ],
            [
                'deadline' => 14,
                'name' => 'Выдача решения на проведение комплекса работ по постутилизации объектов', //15
                'table_name' => 'p15_kompleks_rabot_postutilizacii_object',
            ],
            [
                'deadline' => 18,
                'name' => 'Предоставление земельного участка для строительства объекта в черте населенного пункта(этап 2)', //16
                'table_name' => 'p9_pred_zu_dlya_stroi_v_4erte_2',
            ],
            [
                'deadline' => 3,
                'name' => 'Приобретение прав на земельные участки которые находятся в государственной собственности не требующее проведения торгов(этап 2)' //16
            ],
        ]);
    }
}
