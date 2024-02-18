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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en', 100);
            $table->string('name_ar', 100);
            $table->longText('description_en');
            $table->longText('description_ar');
            $table->string('image');
            $table->enum('type_attribute', ['colors', 'sizes', 'both', 'none'])->default('none');
            $table->unsignedBigInteger('views')->nullable()->default(0);
            $table->integer('arrange')->default(1);
            $table->integer('quantity')->default(1);
            $table->decimal('price', 8, 2);
            $table->boolean('status')->default(true);
            $table->decimal('discount', 8, 1)->nullable();
            $table->decimal('percentage_discount', 8, 1)->nullable();
            $table->decimal('shipping_fee', 8, 1)->nullable()->default(0);
            $table->timestamp('discount_start')->nullable();
            $table->boolean('is_gift')->default(false);
            $table->timestamp('measurement_guide')->nullable();
            $table->timestamp('discount_end')->nullable();
            $table->text('offer')->nullable();
            $table->text('description_measurement_guide')->nullable();
            $table->string('sku')->nullable();
            $table->float('weight')->default(0);
            $table->timestamps();
            $table->unsignedBigInteger('sub_category_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes
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
        Schema::dropIfExists('products');
    }
};
