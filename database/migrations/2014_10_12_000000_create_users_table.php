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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->enum('type', ['user', 'admin', 'vendor', 'affiliate'])->default('user');
            $table->enum('subscription', ['silver', 'golden', 'normal'])->default('normal');
            $table->timestamp('subscription_at')->nullable()->default(now());
            $table->text('fcm')->nullable();
            $table->string('invitation_code')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('cash_on_delivery')->default(true);
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->float('refund')->default(0)->nullable();
            $table->boolean('isfirst')->default(true);
            $table->unsignedBigInteger('referrer_id')->nullable();
            $table->foreign('referrer_id')->references('id')->on('users')->onDelete('set null');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
