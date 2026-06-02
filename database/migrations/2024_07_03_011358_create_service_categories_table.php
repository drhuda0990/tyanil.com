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
        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('image')->nullable();
            $table->text('icon')->nullable();
            $table->text('slug')->nullable();
            $table->text('details')->nullable();
            $table->integer('order_num')->nullable();
            $table->boolean('main_category')->nullable();   
            $table->boolean('activate')->nullable();   
            $table->integer('parent_main_category_id')->nullable();   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_categories');
    }
};
