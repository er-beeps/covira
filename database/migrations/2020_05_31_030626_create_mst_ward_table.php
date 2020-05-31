<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstWardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_ward', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->integer('local_level_code');
            $table->integer('ward');
            $table->string('GaPa_NaPa');
            $table->string('lat_ward',20);
            $table->string('long_ward',20);
            $table->string('lat_municipal',20);
            $table->string('long_municipal',20);
            $table->string('lat_district',20);
            $table->string('long_district',20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_ward');
    }
}
