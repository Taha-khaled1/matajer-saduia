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
        Schema::create('branch_companies', function (Blueprint $table) {
            $table->id();
            $table->string("name_ar");
            $table->string("name_en")->nullable();
            $table->integer("arrange")->default(0);
            $table->string("country")->nullable();
            $table->string("city")->nullable();
            // $table->string("name_ar");
            $table->string("description_en")->nullable();
            $table->string("description_ar")->nullable();
            $table->boolean('status')->default(true);

            $table->string("adress")->nullable();
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
        Schema::dropIfExists('branch_companies');
    }
};
