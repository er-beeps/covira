<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDtRegionalRiskSearch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dt_regional_risk_search', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedSmallInteger('province_id');
            $table->unsignedSmallInteger('district_id');
            $table->unsignedSmallInteger('locallevel_id');
            $table->date('date');
            $table->time('time');
            $table->timestamps();


            $table->foreign('province_id','fk_dt_regional_risk_search_province_id')->references('id')->on('mst_fed_province');
            $table->foreign('district_id','fk_dt_regional_risk_search_district_id')->references('id')->on('mst_fed_district');
            $table->foreign('locallevel_id','fk_dt_regional_risk_search_locallevel_id')->references('id')->on('mst_fed_local_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dt_regional_risk_search');
    }
}
