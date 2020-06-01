<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCovidDetailsNepal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covid_details_nepal', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->timestamps();
            $table->integer('total_affected')->default(0);
            $table->integer('total_recovered')->default(0);
            $table->integer('total_isolation')->default(0);
            $table->integer('total_quarantine')->default(0);
            $table->integer('total_swab_test')->default(0);
            $table->integer('total_death')->default(0);
            $table->string('remarks',500)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('covid_details_nepal', function (Blueprint $table) {
            //
        });
    }
}
