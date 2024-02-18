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
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->string('first_order')->nullable();
            $table->float('first_order_price')->nullable()->default(0);
            $table->string('buying_specified_value')->nullable();
            $table->float('buying_specified_value_price')->nullable()->default(0);
            $table->float('specified_value_price')->nullable()->default(0);
            $table->string('discount_after_first_month')->nullable();
            $table->float('discount_after_first_month_price')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gifts');
    }
};