<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDateSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('date_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('date_ad');
            $table->string('date_bs');
            $table->integer('year_bs');
            $table->integer('month_bs');
            $table->string('days_bs');
            $table->integer('year_ad');
            $table->integer('month_ad');
            $table->string('days_ad');            
            $table->dateTime('created_on')->nullable();         
            $table->dateTime('updated_on')->nullable();         
            $table->dateTime('deleted_on')->nullable();         
            $table->boolean('is_deleted')->default(false);
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
        Schema::dropIfExists('date_settings');
    }
}
