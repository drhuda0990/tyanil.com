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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('name_en')->nullable();
            $table->string('images')->nullable();
            $table->longText('about')->nullable();
            $table->text('summary')->nullable();
            $table->string('degree')->nullable();
            $table->string('nationality')->nullable();
            $table->string('country_live')->nullable();
            $table->string('gender')->default(1)->nullable();
            $table->string('identity')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->boolean('phone_verified')->default(false)->nullable();
            $table->boolean('info_confirm')->default(false)->nullable();
            $table->boolean('whatsapp_verified')->default(false)->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('last_code')->nullable();
            $table->string('email')->unique()->nullable();
            $table->boolean('email_verified')->default(false)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('newsletter')->default(true)->nullable();
            $table->boolean('activate')->default(true)->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('prevent_advertising_emails')->default(0)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
