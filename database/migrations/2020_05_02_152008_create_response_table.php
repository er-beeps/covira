<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('response', function (Blueprint $table) 
        {
            $table->smallIncrements('id');
            $table->string('code',20);
            $table->string('name_en',200);
            $table->string('name_lc',200);
            $table->unsignedSmallInteger('gender_id');
            $table->string('email')->nullable();
            $table->unsignedSmallInteger('province_id');
            $table->unsignedSmallInteger('district_id');
            $table->unsignedSmallInteger('local_level_id');
            $table->unsignedSmallInteger('ward_number')->nullable();  
            $table->unsignedSmallInteger('education_id')->nullable();
            $table->unsignedSmallInteger('profession_id')->nullable();
            $table->string('gps_lat',20)->nullable();
            $table->string('gps_long',20)->nullable();
            $table->unsignedSmallInteger('process_step_id')->nullable();										

            
            $table->timestamps();
            $table->string('remarks',500)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();


            $table->unique('code','uq_response_code');

            $table->foreign('gender_id','fk_response_gender_id')->references('id')->on('mst_gender');
            $table->foreign('province_id','fk_response_province_id')->references('id')->on('mst_fed_province');
            $table->foreign('district_id','fk_response_district_id')->references('id')->on('mst_fed_district');
            $table->foreign('local_level_id','fk_response_local_level_id')->references('id')->on('mst_fed_local_level');
            $table->foreign('education_id','fk_response_education_id')->references('id')->on('mst_educational_level');
            $table->foreign('profession_id','fk_response_profession_id')->references('id')->on('mst_profession');
            $table->foreign('process_step_id','fk_response_process_step_id')->references('id')->on('process_steps');										

 
        });

        Schema::create('respondent_data', function (Blueprint $table) 
        {
            $table->smallIncrements('id');
            $table->unsignedSmallInteger('response_id');
            $table->unsignedSmallInteger('activity_id');
            
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();



            $table->foreign('response_id','fk_respondent_data_response_id')->references('id')->on('response');
            $table->foreign('activity_id','fk_response_activity_id')->references('id')->on('pr_activity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('response');
    }
}
