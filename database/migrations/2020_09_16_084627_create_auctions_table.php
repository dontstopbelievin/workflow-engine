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
            $table->integer('lot_id')->unsigned()->nullable();
            $table->integer('egkn_id')->nullable();
            $table->string('lot_status')->nullable();
            $table->integer('lot_number')->nullable();
            $table->string('status_zu')->nullable();
            $table->date('publish_date')->nullable();
            $table->date('rent_lease')->nullable();
            $table->string('rent_conditions_rus')->nullable();
            $table->string('rent_conditions_kaz')->nullable();
            $table->float('area')->nullable();
            $table->float('cadastre_cost')->nullable();
            $table->float('start_cost')->nullable();
            $table->float('tax_cost')->nullable();
            $table->float('participation_cost')->nullable();
            $table->string('auction_method')->nullable();
            $table->datetime('auction_date_time')->nullable();
            $table->string('auction_place_rus')->nullable();
            $table->string('auction_place_kaz')->nullable();
            $table->string('request_address_rus')->nullable();
            $table->string('request_address_kaz')->nullable();
            $table->string('comment_rus')->nullable();
            $table->string('comment_kaz')->nullable();
            $table->string('ate_id')->nullable();
            $table->string('address_rus')->nullable();
            $table->string('address_kaz')->nullable();
            $table->string('restrictions_and_burdens_rus')->nullable();
            $table->string('restrictions_and_burdens_kaz')->nullable();

            $table->string('coordinates_1')->nullable();
            $table->string('coordinates_2')->nullable();
            $table->string('coordinates_3')->nullable();
            $table->string('coordinates_4')->nullable();
//            $table->string('coordinates')->nullable();
            $table->string('coordinate_system')->nullable();

            $table->string('instalment_selling')->nullable();
            $table->integer('installment_period')->nullable();

            $table->float('elektr_power')->nullable();
            $table->float('elektr_faza_1')->nullable();
            $table->float('elektr_faza_3')->nullable();
            $table->float('water_power')->nullable();
            $table->float('water_hoz')->nullable();
            $table->float('water_production')->nullable();
            $table->float('sewerage_power')->nullable();
            $table->float('sewerage_fecal')->nullable();
            $table->float('sewerage_production')->nullable();
            $table->float('sewerage_clean')->nullable();
            $table->float('heat_power')->nullable();
            $table->float('heat_firing')->nullable();
            $table->float('heat_ventilation')->nullable();
            $table->float('heat_hot_water')->nullable();
            $table->string('storm_water')->nullable();
            $table->string('telekom')->nullable();
            $table->float('gas_power')->nullable();
            $table->float('gas_on_cooking')->nullable();
            $table->float('gas_heating')->nullable();
            $table->float('gas_ventilation')->nullable();
            $table->float('gas_conditioning')->nullable();
            $table->float('gas_hot_water')->nullable();

            $table->string('iin_bin')->nullable();
            $table->string('name_rus')->nullable();
            $table->string('name_kaz')->nullable();
            $table->string('is_fl')->nullable();

            $table->string('target')->nullable();
            $table->string('purpose')->nullable();
            $table->string('right_type')->nullable();
            $table->string('land_divisibility')->nullable();

            $table->string('identification_doc')->nullable();

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
