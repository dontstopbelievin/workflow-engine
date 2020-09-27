<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->string('lot_id');
            $table->string('lot_status');
            $table->string('lot_number');
            $table->string('status_zu');
            $table->string('publish_date');
            $table->string('rent_lease');
            $table->string('rent_conditions_rus');
            $table->string('rent_conditions_kaz');
            $table->string('area');
            $table->string('cadastre_cost');
            $table->string('start_cost');
            $table->string('tax_cost');
            $table->string('participation_cost');
            $table->string('auction_method');
            $table->string('auction_date_time');
            $table->string('auction_place_rus');
            $table->string('auction_place_kaz');
            $table->string('request_address_rus');
            $table->string('request_address_kaz');
            $table->string('comment_rus');
            $table->string('comment_kaz');
            $table->string('ate_id');
            $table->string('address_rus');
            $table->string('address_kaz');
            $table->string('restrictions_and_burdens_rus');
            $table->string('restrictions_and_burdens_kaz');

            $table->string('coordinates_1');
            $table->string('coordinates_2');
            $table->string('coordinates_3');
            $table->string('coordinates_4');
//            $table->string('coordinates');
            $table->string('coordinate_system');

            $table->string('instalment_selling');
            $table->string('installment_period');

            $table->string('elektr_power');
            $table->string('elektr_faza_1');
            $table->string('elektr_faza_3');
            $table->string('water_power');
            $table->string('water_hoz');
            $table->string('water_production');
            $table->string('sewerage_power');
            $table->string('sewerage_fecal');
            $table->string('sewerage_production');
            $table->string('sewerage_clean');
            $table->string('heat_power');
            $table->string('heat_firing');
            $table->string('heat_ventilation');
            $table->string('heat_hot_water');
            $table->string('storm_water');
            $table->string('telekom');
            $table->string('gas_power');
            $table->string('gas_on_cooking');
            $table->string('gas_heating');
            $table->string('gas_ventilation');
            $table->string('gas_conditioning');
            $table->string('gas_hot_water');

            $table->string('iin_bin');
            $table->string('name_rus');
            $table->string('name_kaz');
            $table->string('is_fl');

            $table->string('target');
            $table->string('purpose');
            $table->string('right_type');
            $table->string('land_divisibility');

            $table->string('identification_doc');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auctions');
    }
}
