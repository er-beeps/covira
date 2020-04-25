<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppSecondaryMasterTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pr_hospital', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('code',20);
            $table->string('name_en',200);
            $table->string('name_lc',200);  
            $table->string('gps_lat',20)->nullable();
            $table->string('gps_long',20)->nullable();
            $table->boolean('is_covid_center',20)->default(0);
            $table->unsignedSmallInteger('num_ventilator')->nullable()->default(0);
            $table->unsignedSmallInteger('num_icu')->nullable()->default(0);

            $table->unsignedSmallInteger('display_order')->nullable()->default(0);

            $table->timestamps();
            $table->string('remarks',500)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();


            $table->unique('code','uq_mst_hospital_code');
            $table->unique('name_lc','uq_mst_hospital_name_lc');
            $table->unique('name_en','uq_mst_hospital_name_en');
        });

        Schema::create('pr_quarantine_center', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('code',20);
            $table->string('name_en',200);
            $table->string('name_lc',200);  
            $table->string('gps_lat',20)->nullable();
            $table->string('gps_long',20)->nullable();
            $table->unsignedSmallInteger('capacity')->nullable()->default(0);
            $table->unsignedSmallInteger('num_ventilator')->nullable()->default(0);
            $table->unsignedSmallInteger('num_icu')->nullable()->default(0);

            $table->unsignedSmallInteger('display_order')->nullable()->default(0);

            $table->timestamps();
            $table->string('remarks',500)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();


            $table->unique('code','uq_mst_quarantine_center_code');
            $table->unique('name_lc','uq_mst_quarantine_center_name_lc');
            $table->unique('name_en','uq_mst_quarantine_center_name_en');
        });

        Schema::create('pr_factor', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('code',20);
            $table->string('name_en',200);
            $table->string('name_lc',200);  
            $table->unsignedSmallInteger('display_order')->nullable()->default(0);

            $table->timestamps();
            $table->string('remarks',500)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();


            $table->unique('code','uq_pr_factor_code');
            $table->unique('name_lc','uq_pr_factor_name_lc');
            $table->unique('name_en','uq_pr_factor_name_en');
        });

        Schema::create('pr_activity', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('code',20);
            $table->string('name_en',200);
            $table->string('name_lc',200);  
            $table->unsignedSmallInteger('factor_id');
            $table->unsignedSmallInteger('scale_high')->nullable()->default(0);
            $table->unsignedSmallInteger('scale_low')->nullable()->default(0);
            $table->unsignedSmallInteger('weight_factor')->nullable()->default(0);

            $table->unsignedSmallInteger('display_order')->nullable()->default(0);

            $table->timestamps();
            $table->string('remarks',500)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();


            $table->unique('code','uq_pr_activity_code');
            $table->unique('name_lc','uq_pr_activity_name_lc');
            $table->unique('name_en','uq_pr_activity_name_en');

            $table->foreign('factor_id','fk_pr_activity_factor_id')->references('id')->on('pr_factor');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pr_hospital');
        Schema::dropIfExists('pr_quarantine_center');
        Schema::dropIfExists('pr_factor');
        Schema::dropIfExists('pr_activity');
    }
}
