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

            $table->unsignedBigInteger('request_number');
            $table->string('egkn_status');
            $table->date('request_date');
            $table->unsignedBigInteger('gov_service_id');
            $table->unsignedBigInteger('IIN');
            $table->string('surname');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('phone_number');
            $table->string('city');
            $table->string('purpose_use_ru');
            $table->string('purpose_use_kz');
            $table->unsignedBigInteger('purpose_use_code');
            $table->string('pravo_ru');
            $table->unsignedBigInteger('pravo_code');
            $table->text('coordinates');
            $table->string('functional_use_ru');
            $table->string('functional_use_kz');
            $table->unsignedBigInteger('functional_use_code');
            $table->string('landcat_use_ru');
            $table->string('landcat_use_kz');
            $table->unsignedBigInteger('landcat_use_code');
            $table->string('scheme_file_name');
            $table->string('scheme_file_type');
            $table->string('act_cost_file_name');
            $table->string('act_cost_file_type');

            //additional data
            $table->float('power');
            $table->float('one_phase_electricity');
            $table->float('three_phase_electricity');
            $table->float('total_need_water_amount');
            $table->float('household_water_amount');
            $table->float('industrial_water_amount');
            $table->string('water_disposal')->nullable();
            $table->string('central_sewerage')->nullable();
            $table->string('central_heating')->nullable();
            $table->string('central_hot_water')->nullable();
            $table->string('telephone')->nullable();
            $table->string('gazification')->nullable();
            $table->timestamp('receipt_date')->useCurrent();
            $table->date('execution_date')->nullable();
            $table->boolean('passed_to_process')->default(0);
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
