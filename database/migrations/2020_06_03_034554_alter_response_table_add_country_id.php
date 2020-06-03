<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterResponseTableAddCountryId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('response', function (Blueprint $table) {
            $table->boolean('is_other_country')->nullable();
            $table->unsignedSmallInteger('country_id')->nullable();
            $table->string('city',200)->nullable();

            $table->unsignedSmallInteger('province_id')->nullable()->change();
            $table->unsignedSmallInteger('district_id')->nullable()->change();
            $table->unsignedSmallInteger('local_level_id')->nullable()->change();
            $table->unsignedSmallInteger('ward_number')->nullable()->change();

            $table->foreign('country_id','fk_response_country_id')->references('id')->on('mst_country');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resposne', function (Blueprint $table) {
            //
        });
    }
}
