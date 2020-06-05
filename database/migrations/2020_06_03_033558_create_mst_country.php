<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstCountry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_country', function (Blueprint $table) {
            
            $table->smallIncrements('id');
            $table->string('name_en',200);
            $table->string('name_lc',200);
            $table->string('country_code',20);
            $table->string('capital_name_en',200);
            $table->string('capital_name_lc',200);
            $table->string('cap_lat',20);
            $table->string('cap_long',20);
            $table->string('continent_name_en',20);
            $table->string('continent_name_lc',20);

            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();


            $table->unique('country_code','uq_mst_country_country_code');
            $table->unique('name_lc','uq_mst_country_name_lc');
            $table->unique('name_en','uq_mst_country_name_en');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_country');
    }
}
