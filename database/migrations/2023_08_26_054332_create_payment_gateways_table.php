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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('PAYPAL_SANDBOX_API_USERNAME'); 
            $table->string('PAYPAL_SANDBOX_API_PASSWORD'); 
            $table->string('PAYPAL_SANDBOX_API_SECRET'); 
            $table->string('PAYPAL_SANDBOX_API_CERTIFICATE'); 
            $table->string('PAYPAL_CURRENCY');
            $table->string('PAYPAL_SECURT_KEY');
            $table->string('PAYPAL_PUBLIC_KEY');
            $table->string('PAYPAL_MODE');
            $table->string('CLAIENT_ID');
            $table->string('STRIPE_PUBLISHABLE_KEY');
            $table->string('STRIPE_SECRET_KEY');
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
        Schema::dropIfExists('payment_gateways');
    }
};