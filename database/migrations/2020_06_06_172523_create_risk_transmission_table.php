<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskTransmissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dt_risk_transmission', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('code',20);
            $table->string('district_name',200);
            $table->string('gapa_napa',200);
            $table->string('gapa_napa_type',200);
            $table->string('lat',20);
            $table->string('long',20);
            $table->string('ctr',20);
            $table->string('trs',20);
            $table->timestamps();
            $table->date('date_ad');
            $table->string('date_bs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risk_transmission');
    }
}
