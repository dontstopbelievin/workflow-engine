<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgknServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egkn_services', function (Blueprint $table) {
            $table->id();

            $table->string('egkn_reg_number')->nullable();
            $table->string('egkn_status')->nullable();

            //data zu
            $table->string('iin')->nullable();
            $table->string('surname')->nullable();
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('phonenumber')->nullable();

            //data land
            $table->string('city')->nullable();
            $table->string('cadastre')->nullable();
            $table->float('area')->nullable();
            $table->text('coordinates')->nullable();

            //spravochniki
            $table->string('purpose_use')->nullable();
            $table->string('right_type')->nullable();
            $table->string('functional_use')->nullable();
            $table->string('land_cat')->nullable();

            //additional data
            $table->float('power')->nullable();
            $table->float('one_phase_elec')->nullable();
            $table->float('three_phase_elec')->nullable();
            $table->float('total_need_water_amount')->nullable();
            $table->float('household_water_amount')->nullable();
            $table->float('industrial_water_amount')->nullable();
            $table->string('water_disposal')->nullable();
            $table->string('central_sewerage')->nullable();
            $table->string('central_heating')->nullable();
            $table->string('central_hot_water')->nullable();
            $table->string('telephone')->nullable();
            $table->string('gazification')->nullable();
            $table->timestamp('receipt_date')->useCurrent();
            $table->date('execution_date')->nullable();
            //attachmentfiles
//            $table->string('code_type')->nullable();
//            $table->string('file_name')->nullable();
//            $table->string('file_id')->nullable();
//            $table->string('doc_number')->nullable();
//            $table->string('doc_date')->nullable();
//            $table->string('file_type')->nullable();

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
        Schema::dropIfExists('egkn_services');
    }
}
