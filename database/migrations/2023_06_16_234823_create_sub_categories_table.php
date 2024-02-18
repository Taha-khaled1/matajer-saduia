<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->string('name_en', 100);
            $table->string('name_ar', 100);
            $table->string('image')->nullable();
             $table->boolean('status')->default(true);
            $table->timestamps();
            // Foreign Key
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            // indexes
            $table->index('name_en');
            $table->index('name_ar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_categories');
    }
};