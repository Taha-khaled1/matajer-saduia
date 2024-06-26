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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('email')->nullable();
            $table->string('website_link')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_address')->nullable();
            $table->float('payment_shipping')->default(1);
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->string('google')->nullable();
            $table->string('commercial_register')->nullable();
            $table->string('idtax')->nullable();
            $table->string('idnumber')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();
            $table->text('biographical_information')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('isadmin')->nullable()->default(false);
            $table->string('background_image')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')->onDelete('cascade');;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
