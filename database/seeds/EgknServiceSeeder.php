<?php

use Illuminate\Database\Seeder;

class EgknServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('egkn_services')->insert([
            [
                'request_number' => '1001',
                'egkn_status' => 'Заявка создана',
                'request_date' => \Carbon\Carbon::now(),
                'gov_service_id' => 12334,
                'IIN' => '9820206132456',
                'surname' => 'Жумай',
                'first_name' => 'Нурарыс',
                'middle_name' => 'Ерланулы',
                'phone_number' => '87782294883',
                'city' => 'Астана',
                'coordinates' => 'MULTIPOLYGON(((6384350.16246467 6503096.17235276,6384352.81646335 6502963.4691746,6384167.03218159 6502963.4691746,6384164.37789132 6503096.17235276,6384350.16246467 6503096.17235276)))',
                'purpose_use_ru' => 'Причина',
                'purpose_use_kz' => 'Себеп',
                'purpose_use_code' => '123134',
                'pravo_ru' => 'Право',
                'pravo_code' => '7983625',
                'functional_use_ru' => '123',
                'functional_use_kz' => '123',
                'functional_use_code' => '123',
                'landcat_use_ru' => '123',
                'landcat_use_kz' => '123',
                'landcat_use_code' => '123',
                'scheme_file_name' => 'filename',
                'scheme_file_type' => 'string',
                'act_cost_file_name' => 'filename',
                'act_cost_file_type' => 'string',
                'power' => '12',
                'one_phase_electricity' => '12',
                'three_phase_electricity' => '12',
                'total_need_water_amount' => '121',
                'household_water_amount' => '121',
                'industrial_water_amount' => '121',
                'water_disposal' => 'Да',
                'central_sewerage' => 'Да',
                'central_heating' => 'Да',
                'central_hot_water' => 'Да',
                'telephone' => 'Да',
                'gazification' => 'Да',
                'execution_date' => '2020-11-13',

            ],
            [
                'request_number' => '1002',
                'egkn_status' => 'Заявка создана',
                'request_date' => \Carbon\Carbon::now(),
                'gov_service_id' => 12334,
                'IIN' => '9820206132456',
                'surname' => 'Кажытай',
                'first_name' => 'Куатбек',
                'middle_name' => 'Жаркынулы',
                'phone_number' => '87781234567',
                'city' => 'Астана',
                'coordinates' => 'MULTIPOLYGON(((6384350.16246467 6503096.17235276,6384352.81646335 6502963.4691746,6384167.03218159 6502963.4691746,6384164.37789132 6503096.17235276,6384350.16246467 6503096.17235276)))',
                'purpose_use_ru' => 'Причина',
                'purpose_use_kz' => 'Себеп',
                'purpose_use_code' => '123134',
                'pravo_ru' => 'Право',
                'pravo_code' => '7983625',
                'functional_use_ru' => '123',
                'functional_use_kz' => '123',
                'functional_use_code' => '123',
                'landcat_use_ru' => '123',
                'landcat_use_kz' => '123',
                'landcat_use_code' => '123',
                'scheme_file_name' => 'filename',
                'scheme_file_type' => 'string',
                'act_cost_file_name' => 'filename',
                'act_cost_file_type' => 'string',
                'power' => '12',
                'one_phase_electricity' => '12',
                'three_phase_electricity' => '12',
                'total_need_water_amount' => '121',
                'household_water_amount' => '121',
                'industrial_water_amount' => '121',
                'water_disposal' => 'Да',
                'central_sewerage' => 'Да',
                'central_heating' => 'Да',
                'central_hot_water' => 'Да',
                'telephone' => 'Да',
                'gazification' => 'Да',
                'execution_date' => '2020-11-13',

            ],

        ]);
    }
}
