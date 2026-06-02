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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('image')->nullable();
            $table->text('summry')->nullable();
            $table->integer('service_category_id')->nullable();
            $table->text('price_1')->nullable();
            $table->text('price_2')->nullable();
            $table->longText('body')->nullable();
            $table->string('tags')->nullable();
            $table->string('video')->nullable();
            $table->text('embided_book')->nullable();
            $table->text('book_type')->nullable();
            $table->text('service_mail_1_date')->nullable();
            $table->text('service_mail_2_date')->nullable();
            $table->text('service_mail_1')->nullable();
            $table->text('service_mail_2')->nullable();
            $table->text('required_shipment')->nullable();
            $table->text('purchase_message')->nullable();
            $table->text('purchase_email')->nullable();
            $table->boolean('tutorial')->nullable();
            $table->boolean('price_start_from')->nullable();
            $table->text('times_available')->nullable();
            $table->text('times_from_date')->nullable();
            $table->text('service_admins')->nullable();
            $table->text('times_to_date')->nullable();
            $table->json('times')->nullable();
            $table->boolean('disable_coupon')->default(false)->nullable();
            $table->boolean('is_available_hidden')->default(true)->nullable();
            $table->boolean('activate')->nullable();
            $table->boolean('not_available')->nullable();
            $table->boolean('advertizment_service')->nullable();
            $table->text('redirect_url')->nullable();
            $table->text('attachment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
