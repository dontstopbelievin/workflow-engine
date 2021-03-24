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
                'name' => 'applicant_address',
                'label_name' => 'Адрес проживания(физ)/местонахождения(юр)',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'attachment',
                'label_name' => 'Загрузите Файл',
                'input_type_id' => 2,
                'insert_type_id' => 1
            ],
            [
                'name' => 'request_number',
                'label_name' => 'Номер запроса',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'egkn_status',
                'label_name' => 'Статус ЕГКН',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'request_date',
                'label_name' => 'Дата запроса',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'gov_service_id',
                'label_name' => 'Сервисный номер',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'IIN',
                'label_name' => 'ИИН',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'first_name',
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
                'name' => 'middle_name',
                'label_name' => 'Отчество',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'phone_number',
                'label_name' => 'Номер телефона',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'city',
                'label_name' => 'Город',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'purpose_use_ru',
                'label_name' => 'Цель назначения (рус)',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'purpose_use_kz',
                'label_name' => 'Цель назначения (кз)',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'purpose_use_code',
                'label_name' => 'Цель назначения (код)',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'pravo_ru',
                'label_name' => 'Вид права (рус)',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'pravo_code',
                'label_name' => 'Вид права (код)',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'coordinates',
                'label_name' => 'Координаты',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'functional_use_ru',
                'label_name' => 'Функциональное назначение (рус)',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'functional_use_kz',
                'label_name' => 'Функциональное назначение (кз)',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'functional_use_code',
                'label_name' => 'Функциональное назначение (код)',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'landcat_use_ru',
                'label_name' => 'Категория земель (рус)',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'landcat_use_kz',
                'label_name' => 'Категория земель (каз)',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'landcat_use_code',
                'label_name' => 'Категория земель (код)',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'scheme_file_name',
                'label_name' => 'Название схемы',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'scheme_file_type',
                'label_name' => 'Тип файла схемы',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'act_cost_file_name',
                'label_name' => 'Название акта стоимости ',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'act_cost_file_type',
                'label_name' => 'Тип файла акта стоимости',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'power',
                'label_name' => 'Мощность',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'one_phase_electricity',
                'label_name' => 'Электричество (однофазовая)',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'three_phase_electricity',
                'label_name' => 'Электричество (трехфазовая)',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'total_need_water_amount',
                'label_name' => 'Необходимое количество воды для общего использвания',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'household_water_amount',
                'label_name' => 'Необходимое количество воды для домашнего использвания',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'industrial_water_amount',
                'label_name' => 'Необходимое количество воды для индустриального использвания',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'water_disposal',
                'label_name' => 'Утилизация воды',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'central_sewerage',
                'label_name' => 'Центральная канализация',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'central_heating',
                'label_name' => 'Центральное отопление',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'central_hot_water',
                'label_name' => 'Горячяя вода',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'telephone',
                'label_name' => 'Телефон',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'gazification',
                'label_name' => 'Газификация',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'receipt_date',
                'label_name' => 'Дата рецепта',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'execution_date',
                'label_name' => 'Дата выполнения',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
            [
                'name' => 'passed_to_process',
                'label_name' => 'Отправлен в сервис',
                'input_type_id' => 1,
                'insert_type_id' => 1
            ],
             [
                 'name' => 'dictionary_target',
                 'label_name' => 'Справочник цель использования',
                 'input_type_id' => 3,
                 'insert_type_id' => 6
             ],
             [
                 'name' => 'dictionary_purpose',
                 'label_name' => 'Целевое назначение земельного участка',
                 'input_type_id' => 3,
                 'insert_type_id' => 6
             ],
             [
                 'name' => 'dictionary_right_type',
                 'label_name' => 'Вид права использования',
                 'input_type_id' => 3,
                 'insert_type_id' => 6
             ],
             [
                 'name' => 'dictionary_land_category',
                 'label_name' => 'Справочник категория земель',
                 'input_type_id' => 3,
                 'insert_type_id' => 6
             ],
             [
                 'name' => 'dictionary_land_divisibility',
                 'label_name' => 'Делимость земель',
                 'input_type_id' => 3,
                 'insert_type_id' => 6
             ],
             [
                 'name' => 'ulica_mestop_z_u',
                 'label_name' => 'Улица (местоположение) земельного участка',
                 'input_type_id' => 1,
                 'insert_type_id' => 1
             ],
             [
                 'name' => 'area',
                 'label_name' => 'Площадь(в гектарах)',
                 'input_type_id' => 1,
                 'insert_type_id' => 1
             ],
             [
                 'name' => 'cel_razdela',
                 'label_name' => 'Цель раздела',
                 'input_type_id' => 1,
                 'insert_type_id' => 1
             ],
             [
                 'name' => 'region',
                 'label_name' => 'Район',
                 'input_type_id' => 3,
                 'insert_type_id' => 1
             ],
             [
                 'name' => 'construction_name_before',
                 'label_name' => 'Изменить с целевого назначения',
                 'input_type_id' => 3,
                 'insert_type_id' => 1
             ],
             [
                 'name' => 'construction_name_after',
                 'label_name' => 'Изменить на целевое назначение',
                 'input_type_id' => 3,
                 'insert_type_id' => 1
             ],
             [
                 'name' => 'cadastral_number',
                 'label_name' => 'Кадастровый номер',
                 'input_type_id' => 1,
                 'insert_type_id' => 1
             ],
             [
                 'name' => 'pri4ina_i_c_n',
                 'label_name' => 'Причина изменения целевого назначения',
                 'input_type_id' => 1,
                 'insert_type_id' => 1
             ],
             [
                 'name' => 'pravoustan_doc',
                 'label_name' => 'Правоустанавливающий документ №',
                 'input_type_id' => 1,
                 'insert_type_id' => 1
             ],
             [
                 'name' => 'pravoustan_doc_date',
                 'label_name' => 'Правоустанавливающий документ от(дата)',
                 'input_type_id' => 1,
                 'insert_type_id' => 1
             ],
             [
                 'name' => 'identific_doc',
                 'label_name' => 'Идентификационный документ №',
                 'input_type_id' => 1,
                 'insert_type_id' => 1
             ],
             [
                 'name' => 'identific_doc_date',
                 'label_name' => 'Идентификационный документ от(дата)',
                 'input_type_id' => 1,
                 'insert_type_id' => 1
             ],
             
        ]);
    }
}
