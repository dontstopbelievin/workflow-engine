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
            $table->string('iin');
            $table->string('surname');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('phone_number');
            $table->string('purpose_use');
            $table->string('city');
            $table->string('cadastre');
            $table->string('area');
            $table->string('identification_doc');
            $table->string('legal_doc');
            $table->string('sketch_doc');
            $table->string('scheme_zu_doc');
            $table->string('act_cost_doc');
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
