<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppPrimaryMasterTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_fed_province', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('code',20);
            $table->string('name_en',200);
            $table->string('name_lc',200);
            $table->string('geo_json')->nullable();

            $table->timestamps();
            $table->string('remarks',500)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();


            $table->unique('code','uq_mst_fed_province_code');
            $table->unique('name_lc','uq_mst_fed_province_name_lc');
            $table->unique('name_en','uq_mst_fed_province_name_en');

        });

        Schema::create('mst_fed_district', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedSmallInteger('province_id');
            $table->string('code',20);
            $table->string('name_en',200);
            $table->string('name_lc',200);
            $table->string('geo_json')->nullable();

            $table->timestamps();
            $table->string('remarks',500)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->unique('code','uq_mst_fed_district_code');
            $table->unique('name_lc','uq_mst_fed_district_name_lc');
            $table->unique('name_en','uq_mst_fed_district_name_en');
            $table->index('province_id','idx_mst_fed_district_province_id');

            $table->foreign('province_id','fk_mst_fed_district_province_id')->references('id')->on('mst_fed_province');

        });
        Schema::create('mst_fed_local_level_type', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->timestamps();
            $table->string('code',20);
            $table->string('name_en',200);
            $table->string('name_lc',200);
            $table->string('remarks',500)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->unique('code','uq_mst_fed_local_level_type_code');
            $table->unique('name_lc','uq_mst_fed_local_level_type_name_lc');
            $table->unique('name_en','uq_mst_fed_local_level_type_name_en');

        });
        Schema::create('mst_fed_local_level', function (Blueprint $table) {
            $table->increments('id');

            $table->timestamps();
            $table->unsignedSmallInteger('district_id');
            $table->string('code',20);
            $table->string('name_en',200);
            $table->string('name_lc',200);
            $table->unsignedSmallInteger('level_type_id');
            $table->unsignedSmallInteger('wards_count')->nullable()->default(0);
            $table->string('geo_json')->nullable();
            $table->string('remarks',500)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->string('gps_lat',20)->nullable();
            $table->string('gps_long',20)->nullable();

            $table->unique('code','uq_mst_fed_local_level_code');
            // $table->unique('name_lc','uq_mst_fed_local_level_name_lc');
            // $table->unique('name_en','uq_mst_fed_local_level_name_en');

            $table->foreign('district_id','fk_mst_fed_local_level_district_id')->references('id')->on('mst_fed_district');
            $table->foreign('level_type_id','fk_mst_fed_local_level_level_type_id')->references('id')->on('mst_fed_local_level_type');

        });
      
        Schema::create('mst_nepali_month', function (Blueprint $table) {
            $table->smallIncrements('id');

            $table->timestamps();
            $table->string('code',20);
            $table->string('name_en',200);
            $table->string('name_lc',200);
            $table->string('remarks',500)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->unique('code','uq_mst_nepali_month_code');
            $table->unique('name_lc','uq_mst_nepali_month_name_lc');
            $table->unique('name_en','uq_mst_nepali_month_name_en');

        });
        Schema::create('mst_fiscal_year', function (Blueprint $table) {
            $table->smallIncrements('id');

            $table->timestamps();
            $table->string('code',20);
            $table->string('from_date_bs',10)->nullable();
            $table->date('from_date_ad')->nullable();
            $table->string('to_date_bs',10)->nullable();
            $table->date('to_date_ad')->nullable();
            $table->string('remarks',500)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->unique('code','uq_mst_fiscal_year_code');
            $table->unique('from_date_bs','uq_mst_fiscal_year_from_date_bs');
            $table->unique('from_date_ad','uq_mst_fiscal_year_from_date_ad');

        });

        Schema::create('mst_gender', function(Blueprint $table) {
            $table->smallIncrements('id');
            $table->timestamps();
            $table->string('name_en',200);
            $table->string('name_lc',200);
            $table->string('remarks',500)->nullable();
            $table->unsignedSmallInteger('display_order')->nullable()->default(0);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->unique('name_lc','uq_mst_gender_name_lc');
            $table->unique('name_en','uq_mst_gender_name_en');
        });

        Schema::create('mst_educational_level', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('code',20);
            $table->string('name_en',200);
            $table->string('name_lc',200);  
            $table->unsignedSmallInteger('display_order')->nullable()->default(0);

            $table->timestamps();
            $table->string('remarks',500)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();


            $table->unique('code','uq_mst_educational_level_code');
            $table->unique('name_lc','uq_mst_educational_level_name_lc');
            $table->unique('name_en','uq_mst_educational_level_name_en');
        });

        Schema::create('mst_profession', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('code',20);
            $table->string('name_en',200);
            $table->string('name_lc',200);  
            $table->unsignedSmallInteger('display_order')->nullable()->default(0);

            $table->timestamps();
            $table->string('remarks',500)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();


            $table->unique('code','uq_mst_profession_code');
            $table->unique('name_lc','uq_mst_profession_name_lc');
            $table->unique('name_en','uq_mst_profession_name_en');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_fed_province');
        Schema::dropIfExists('mst_fed_district');
        Schema::dropIfExists('mst_fed_local_level_type');
        Schema::dropIfExists('mst_fed_local_level');
        Schema::dropIfExists('mst_nepali_month');
        Schema::dropIfExists('mst_fiscal_year');
        Schema::dropIfExists('mst_gender');
        Schema::dropIfExists('mst_educational_level');
        Schema::dropIfExists('mst_profession');

    }
}
