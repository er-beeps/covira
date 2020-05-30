<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageUploadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_upload', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('code',20);
            $table->timestamps();
            $table->unsignedSmallInteger('image_category_id');
            $table->string('image_path');

            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->unique('code','uq_image_upload_code');
            $table->foreign('image_category_id','fk_image_upload_image_category_id')->references('id')->on('image_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_upload');
    }
}
