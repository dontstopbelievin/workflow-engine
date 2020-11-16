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
                'egkn_reg_number' => '1001',
                'egkn_status' => 'Заявка создана',
                'iin' => 980220350957,
                'surname' => 'Жумай',
                'firstname' => 'Нурарыс',
                'middlename' => 'Ерланулы',
                'phonenumber' => '87782294883',

                'city' => 'Астана',
                'cadastre' => '123456-123456-123456',
                'area' => '21',
                'coordinates' => 'MULTIPOLYGON(((6384350.16246467 6503096.17235276,6384352.81646335 6502963.4691746,6384167.03218159 6502963.4691746,6384164.37789132 6503096.17235276,6384350.16246467 6503096.17235276)))',

                'purpose_use' => '123',
                'right_type' => '123',
                'functional_use' => '123',
                'land_cat' => '123',

                'power' => '12',
                'one_phase_elec' => '12',
                'three_phase_elec' => '12',
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

                //file attachment
            ],

        ]);
    }
}
