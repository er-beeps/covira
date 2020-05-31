<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCounterInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counter_info', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('like_counter');
            $table->integer('dislike_counter');
            $table->integer('views_counter');
            $table->integer('share_counter');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counter_info');
    }
}
