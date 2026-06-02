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
        Schema::create('cv_section_templates', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->integer('cv_template_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->text('date')->nullable();
            $table->longText('content')->nullable();
            $table->text('order_num')->nullable();
            $table->text('location')->nullable();
            $table->text('url')->nullable();
            $table->text('expert_level')->nullable();
            $table->text('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cv_section_templates');
    }
};
