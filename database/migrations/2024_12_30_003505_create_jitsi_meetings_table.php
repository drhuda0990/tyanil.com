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
        Schema::create('jitsi_meetings', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();   
            $table->text('details')->nullable();  
            $table->text('meeting_data')->nullable();   
            $table->text('start_date')->nullable();  
            $table->text('end_date')->nullable(); 
            $table->text('start_time')->nullable();  
            $table->text('end_time')->nullable(); 
            $table->text('meeting_url')->nullable(); 
            $table->integer('service_id')->nullable();   
            $table->integer('customer_id')->nullable();   
            $table->integer('service_invoice_items_id')->nullable();   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jitsi_meetings');
    }
};
