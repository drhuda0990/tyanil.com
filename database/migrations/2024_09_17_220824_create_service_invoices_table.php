<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_invoices', function (Blueprint $table) {
            $table->id();
            $table->longText('title')->nullable();
            $table->integer('customer_id')->nullable()->default(0);
            $table->integer('customer_address_id')->nullable()->default(0);
            $table->double('amount')->nullable()->default(0);
            $table->double('paid_amount')->nullable();
            $table->double('tax_amount')->nullable();
            $table->integer('method')->nullable()->default(1); // طريقة الدفع
            $table->text('time')->nullable();
            $table->boolean('term_accept')->nullable();
            $table->text('note')->nullable();
            $table->string('discount_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('county')->nullable();
            $table->string('name')->nullable();
            $table->text('address')->nullable();
            $table->text('street')->nullable();
            $table->string('city')->nullable();
            $table->double('service_price')->nullable()->default(0);
            $table->double('shipment_price')->nullable();
            $table->integer('discount_id')->nullable()->default(0);
            $table->boolean('state')->default(true)->nullable();
            $table->boolean('activate')->nullable();
            $table->double('discount')->nullable()->default(0);
            $table->double('discount_percent')->nullable()->default(0);
            $table->string('how_know_us')->nullable();
            $table->integer('user_id')->nullable()->default(1);
            $table->string('refrence_id')->nullable();
            $table->json('payment_data')->nullable();
            $table->text('status')->nullable();   
            $table->integer('user_type')->nullable()->default(1); // 1 =User | 2 trainee     
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_invoices');
    }
};
