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

            $table->unsignedSmallInteger('neighbour_proximity')->nullable();										
            $table->unsignedSmallInteger('community_situation')->nullable();										
            $table->unsignedSmallInteger('confirmed_case')->nullable();										
            $table->unsignedSmallInteger('inbound_foreign_travel')->nullable();										
            $table->unsignedSmallInteger('community_population')->nullable();										
            $table->unsignedSmallInteger('hospital_proximity')->nullable();										
            $table->unsignedSmallInteger('corona_centre_proximity')->nullable();										
            $table->unsignedSmallInteger('health_facility')->nullable();										
            $table->unsignedSmallInteger('market_proximity')->nullable();										
            $table->unsignedSmallInteger('food_stock')->nullable();										
            $table->unsignedSmallInteger('agri_producer_seller')->nullable();										
            $table->unsignedSmallInteger('product_selling_price')->nullable();										
            $table->unsignedSmallInteger('commodity_availability')->nullable();										
            $table->unsignedSmallInteger('commodity_price_difference')->nullable();										
            $table->unsignedSmallInteger('job_status')->nullable();										
            $table->unsignedSmallInteger('sustainability_duration')->nullable();										

            
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
            
            $table->foreign('neighbour_proximity','fk_response_neighbour_proximity')->references('id')->on('pr_activity');
            $table->foreign('community_situation','fk_response_community_situation')->references('id')->on('pr_activity');
            $table->foreign('confirmed_case','fk_response_confirmed_case')->references('id')->on('pr_activity');
            $table->foreign('inbound_foreign_travel','fk_response_inbound_foreign_travel')->references('id')->on('pr_activity');
            $table->foreign('community_population','fk_response_community_population')->references('id')->on('pr_activity');
            $table->foreign('hospital_proximity','fk_response_hospital_proximity')->references('id')->on('pr_activity');
            $table->foreign('corona_centre_proximity','fk_response_corona_centre_proximity')->references('id')->on('pr_activity');
            $table->foreign('health_facility','fk_response_health_facility')->references('id')->on('pr_activity');
            $table->foreign('market_proximity','fk_response_market_proximity')->references('id')->on('pr_activity');
            $table->foreign('food_stock','fk_response_food_stock')->references('id')->on('pr_activity');
            $table->foreign('agri_producer_seller','fk_response_agri_producer_seller')->references('id')->on('pr_activity');
            $table->foreign('product_selling_price','fk_response_product_selling_price')->references('id')->on('pr_activity');
            $table->foreign('commodity_availability','fk_response_commodity_availability')->references('id')->on('pr_activity');
            $table->foreign('commodity_price_difference','fk_response_commodity_price_difference')->references('id')->on('pr_activity');
            $table->foreign('job_status','fk_response_job_status')->references('id')->on('pr_activity');
            $table->foreign('sustainability_duration','fk_response_sustainability_duration')->references('id')->on('pr_activity');


 
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
