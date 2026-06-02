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
        Schema::create('ser_invoice_items_features', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();   
            $table->text('details')->nullable();  
            $table->double('price')->nullable();   
            $table->integer('customer_id')->nullable();  
            $table->integer('service_invoice_item_id')->nullable();  
            $table->integer('additional_feature_id')->nullable();  
            $table->integer('service_invoice_id')->nullable();  
            $table->integer('service_id')->nullable();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ser_invoice_items_features');
    }
};
