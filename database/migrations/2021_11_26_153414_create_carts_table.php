<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
        $table->id();
            $table->string('title')->nullable();
            $table->integer('service_id')->nullable()->default(0);
            $table->integer('customer_service_id')->nullable()->default(0);
            $table->integer('customer_id')->nullable()->default(0);
            $table->double('amount')->nullable()->default(0);
            $table->double('paid_amount')->nullable();
            $table->integer('method')->nullable()->default(1); // طريقة الدفع  
            $table->text('transfer_bill')->nullable();
            $table->text('note')->nullable();
            $table->text('time')->nullable();
            $table->text('book_type')->nullable();
            $table->text('additional_features')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('discount_code')->nullable();
            $table->double('service_price')->nullable()->default(0);
            $table->double('tax_amount')->nullable();
            $table->integer('discount_id')->nullable()->default(0);
            $table->double('shipment_price')->nullable();
            $table->double('discount')->nullable()->default(0);
            $table->boolean('activate')->default(true)->nullable();
            $table->boolean('term_accept')->nullable();
            $table->integer('user_id')->nullable()->default(1);
            $table->text('user_ip')->nullable();
            $table->string('refrence_id')->nullable();
            $table->string('payment_code')->nullable();
            $table->string('how_know_us')->nullable();
            $table->json('payment_data')->nullable();
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
        Schema::dropIfExists('carts');
    }
}
