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
        Schema::create('service_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();   
            $table->text('details')->nullable();   
            $table->double('s_price')->nullable();   
            $table->double('purchase_price')->nullable();   
            $table->integer('service_id')->nullable();   
            $table->integer('service_invoice_id')->nullable();   
            // $table->integer('service_order_id')->nullable();   
            $table->integer('customer_id')->nullable();   
            $table->text('attachments')->nullable(); 
            $table->text('time')->nullable(); 
            $table->json('meeting_data')->nullable(); 
            $table->text('admin_attachments')->nullable(); 
            $table->text('admin_response')->nullable(); 
            $table->double('shipment_price')->nullable();
            $table->text('status')->nullable();   
            $table->text('book_type')->nullable();
            $table->boolean('activate')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_invoice_items');
    }
};
