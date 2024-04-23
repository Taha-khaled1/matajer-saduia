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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('status', ['pending', 'processing', 'delivering', 'completed', 'cancelled', 'refunded', 'shipped', 'bill_lading'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->enum('payment_method', ['cash_on_delivery', 'stripe', 'paypal', 'tap'])->default('cash_on_delivery'); // stripe or paypal or cash_on_delivery
            $table->string('currency')->nullable()->default('aed');
            $table->string('policy_number')->nullable()->default('0');
            $table->float('total_country_tax')->default(0);
            $table->boolean('cancelled')->default(false);
            $table->boolean('isrefund')->default(false);
            $table->float('refound_money')->default(0);
            // delivery number
            $table->string('delivery_number')->nullable();
            $table->string('bill_lading_number')->nullable();
            // shipping_cost // مجموع سعر اوزان كل المنتجات
            $table->float('tax')->default(0);
            $table->float('shipping')->default(0);
            $table->float('discount')->default(0);
            $table->float('subtotal')->default(0);
            $table->float('weight')->default(0);
            $table->float('total')->default(0);
            $table->text('description')->nullable();
            $table->timestamp('delivery_time')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('shope_id')->nullable();
            $table->unsignedBigInteger('user_address_id');
            $table->unsignedBigInteger('coupon_id')->nullable();

            $table->unsignedBigInteger('mosaoq_id')->nullable();
            $table->foreign('mosaoq_id')
                ->references('id')
                ->on('users')->onDelete('cascade');

            $table->foreign('shope_id')
                ->references('id')

                ->on('users')->onDelete('cascade');
            $table->foreign('coupon_id')
                ->references('id')

                ->on('coupons')->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')->onDelete('cascade');

            $table->foreign('user_address_id')
                ->references('id')
                ->on('user_addresses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
