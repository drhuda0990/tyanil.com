<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();

            $table->string('code')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('type')->nullable();
            $table->string('date_1')->nullable();
            $table->string('date_2')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('repetition')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('service_id')->nullable();
            $table->integer('minimum_price')->nullable();
            $table->integer('user_id')->nullable();
            $table->boolean('activate')->default(false)->nullable();
            $table->boolean('date_activate')->default(false)->nullable();
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
        Schema::dropIfExists('discounts');
    }
}
