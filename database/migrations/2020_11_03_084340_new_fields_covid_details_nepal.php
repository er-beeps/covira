<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewFieldsCovidDetailsNepal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('covid_details_nepal', function (Blueprint $table) {
            $table->integer('new_pcr')->default(0);
            $table->integer('new_cases')->default(0);
            $table->integer('new_recovered')->default(0);
            $table->integer('new_death')->default(0);

            $table->dateTime('updated_timestamp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
