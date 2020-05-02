<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessFlowTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('step_master', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->timestamps();
            $table->string('code',20);
            $table->string('name_en',200);
            $table->string('name_lc',200);
            $table->string('current_step_name_en',200)->nullable();
            $table->string('current_step_name_lc',200)->nullable();
            $table->unsignedSmallInteger('display_order')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(true);
            $table->string('remarks',500)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->unique('code','uq_step_master_code');
            $table->unique('name_en','uq_step_master_name_en');
            $table->unique('name_lc','uq_step_master_name_lc');
        });



            Schema::create('process_steps', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('code',20);
            $table->unsignedSmallInteger('step_id')->nullable();
            $table->unsignedSmallInteger('back_step_id')->nullable();
            $table->unsignedSmallInteger('next_step_id')->nullable();
            $table->boolean('is_first_step')->nullable()->default(false);
            $table->boolean('is_active')->nullable()->default(true);
            $table->string('remarks',500)->nullable();
            $table->unsignedSmallInteger('display_order')->nullable()->default(0);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('step_id','fk_process_steps_step_id')->references('id')->on('step_master');
            $table->foreign('back_step_id','fk_process_steps_back_step_id')->references('id')->on('step_master');
            $table->foreign('next_step_id','fk_process_steps_next_step_id')->references('id')->on('step_master');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('process_flow_tables');
    }
}
