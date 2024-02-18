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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();   
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('city')->nullable();
            $table->string('zip')->nullable();
            $table->string('address_1')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitudes')->nullable();
            $table->string('location_id')->nullable();
            $table->string('address_2')->nullable();
            $table->string('name');  
            $table->string('email');
            $table->string('phone');
            $table->string('delivery_instruction')->nullable();
            $table->integer('default')->default(2)->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_addresses');
    }
};