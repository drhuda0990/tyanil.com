<?php

namespace App\Support;

use App\GeneralSetting;
use Illuminate\Support\Facades\Schema;
use Throwable;

class StoreSettings
{
    public static function get(): GeneralSetting
    {
        static $settings;

        if ($settings instanceof GeneralSetting) {
            return $settings;
        }

        $settings = self::fallback();

        try {
            if (! Schema::hasTable('general_settings')) {
                return $settings;
            }

            $stored = GeneralSetting::query()->first();

            if (! $stored) {
                return $settings;
            }

            foreach (self::defaults() as $key => $value) {
                if ($stored->{$key} === null) {
                    $stored->setAttribute($key, $value);
                }
            }

            $settings = $stored;
        } catch (Throwable $exception) {
            report($exception);
        }

        return $settings;
    }

    public static function defaults(): array
    {
        return [
            'title' => config('app.name', 'تيانيل'),
            'name' => config('app.name', 'تيانيل'),
            'name_en' => 'Tyaniel',
            'slogan' => 'منتجات نسائية منتقاة بلمسة فاخرة',
            'summary' => 'تيانيل متجر نسائي راق يجمع قطع الكروشيه، الأزياء، الشنط، الأحذية، الأكسسوارات، ومنتجات الجمال في تجربة شراء ناعمة وفاخرة.',
            'about' => 'تيانيل يختار للمرأة منتجات أنثوية أنيقة بتفاصيل رقيقة، خامات مريحة، وألوان متناسقة تناسب الإطلالات اليومية والمناسبات.',
            'vision' => 'أن تصبح تيانيل وجهة نسائية موثوقة لقطع مختارة تجمع الرقة، الجودة، وسهولة التسوق.',
            'message' => 'نقدم منتجات نسائية مصممة لتكميل الإطلالة بثقة، من قطعة الكروشيه اليدوية إلى لمسة الجمال الأخيرة.',
            'logo' => 'tyaniel/logo-footer-horizontal.png',
            'logo2' => 'tyaniel/logo-header-main.png',
            'favicon' => 'tyaniel/favicon.svg',
            'default_service_image' => 'tyaniel/default-product.png',
            'color_1' => '#D989A3',
            'color_2' => '#4B213F',
            'color_3' => '#FFF4EF',
            'email_1' => 'hello@tyaniel.com',
            'email_2' => 'care@tyaniel.com',
            'phone' => '0500000000',
            'mobile' => '0500000000',
            'whatsapp' => '500000000',
            'address' => 'الرياض، المملكة العربية السعودية',
            'pobox' => '00000',
            'commercial_register' => '0000000000',
            'business_register_number' => '7033071270',
            'tax' => 15,
            'shipment_price' => 0,
            'tapPaymentActivate' => false,
            'tapSectretKey' => null,
            'tapPublicKey' => null,
            'sender_user' => null,
            'sender_password' => null,
            'sender_name' => config('app.name', 'Tyaniel'),
            'payment_mode' => 'test',
            'manualPaymentActivate' => true,
            'mail_provider' => 'log',
            'sms_provider' => '4jawaly',
            'emailNotificationsActivate' => true,
            'smsNotificationsActivate' => false,
            'internalNotificationsActivate' => true,
            'orderNotificationsActivate' => true,
            'contactNotificationsActivate' => true,
            'customerNotificationsActivate' => true,
            'inventoryNotificationsActivate' => false,
            'admin_notification_email' => 'care@tyaniel.com',
            'admin_notification_phone' => '0500000000',
        ];
    }

    private static function fallback(): GeneralSetting
    {
        $settings = new GeneralSetting();
        $settings->forceFill(self::defaults());

        return $settings;
    }
}
