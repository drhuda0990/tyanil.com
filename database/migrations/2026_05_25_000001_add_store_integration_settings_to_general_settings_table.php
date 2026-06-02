<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->string('payment_mode')->nullable()->after('user_id');
            $table->boolean('manualPaymentActivate')->default(true)->nullable()->after('payment_mode');
            $table->string('mail_provider')->nullable()->after('MAIL_FROM_ADDRESS');
            $table->string('sms_provider')->nullable()->after('sender_name');
            $table->boolean('emailNotificationsActivate')->default(true)->nullable()->after('MAILGUN_SECRET');
            $table->boolean('smsNotificationsActivate')->default(false)->nullable()->after('emailNotificationsActivate');
            $table->boolean('internalNotificationsActivate')->default(true)->nullable()->after('smsNotificationsActivate');
            $table->boolean('orderNotificationsActivate')->default(true)->nullable()->after('internalNotificationsActivate');
            $table->boolean('contactNotificationsActivate')->default(true)->nullable()->after('orderNotificationsActivate');
            $table->boolean('customerNotificationsActivate')->default(true)->nullable()->after('contactNotificationsActivate');
            $table->boolean('inventoryNotificationsActivate')->default(false)->nullable()->after('customerNotificationsActivate');
            $table->string('admin_notification_email')->nullable()->after('inventoryNotificationsActivate');
            $table->string('admin_notification_phone')->nullable()->after('admin_notification_email');
        });
    }

    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->dropColumn([
                'payment_mode',
                'manualPaymentActivate',
                'mail_provider',
                'sms_provider',
                'emailNotificationsActivate',
                'smsNotificationsActivate',
                'internalNotificationsActivate',
                'orderNotificationsActivate',
                'contactNotificationsActivate',
                'customerNotificationsActivate',
                'inventoryNotificationsActivate',
                'admin_notification_email',
                'admin_notification_phone',
            ]);
        });
    }
};
