<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class PaymentGatewaySetting extends Resource
{
    public static $model = \App\GeneralSetting::class;
    public static $title = 'name';
    public static $group = 'التكاملات والإعدادات';
    public static $search = ['id', 'name'];

    public static function label()
    {
        return 'بوابات الدفع';
    }

    public static function singularLabel()
    {
        return 'إعداد بوابات الدفع';
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Heading::make('تشغيل الدفع'),
            Select::make('وضع الدفع', 'payment_mode')
                ->options([
                    'test' => 'تجريبي',
                    'live' => 'فعلي',
                ])
                ->displayUsingLabels()
                ->hideFromIndex(),
            Boolean::make('تفعيل الدفع اليدوي عند تعطل البوابة', 'manualPaymentActivate')
                ->hideFromIndex(),

            Heading::make('Tap Payments'),
            Boolean::make('تفعيل Tap', 'tapPaymentActivate'),
            Text::make('Tap Secret Key', 'tapSectretKey')
                ->withMeta(['extraAttributes' => ['type' => 'password']])
                ->onlyOnForms(),
            Text::make('Tap Public Key', 'tapPublicKey')
                ->hideFromIndex(),

            Heading::make('Tabby'),
            Boolean::make('تفعيل Tabby', 'tabbyPaymentActivate'),
            Text::make('Tabby Secret Key', 'tabbySectretKey')
                ->withMeta(['extraAttributes' => ['type' => 'password']])
                ->onlyOnForms(),
            Text::make('Tabby Public Key', 'tabbyPublicKey')
                ->hideFromIndex(),

            Heading::make('Tamara'),
            Boolean::make('تفعيل Tamara', 'tamaraPaymentActivate'),
            Text::make('Tamara API URL', 'tamaraApiUrl')->hideFromIndex(),
            Text::make('Tamara Token', 'tamaraToken')
                ->withMeta(['extraAttributes' => ['type' => 'password']])
                ->onlyOnForms(),
            Text::make('Tamara Notification Token', 'tamaraNotificationToken')
                ->withMeta(['extraAttributes' => ['type' => 'password']])
                ->onlyOnForms(),
            Text::make('Tamara Public Key', 'tamaraPublicKey')->hideFromIndex(),

            Heading::make('Madfu'),
            Boolean::make('تفعيل Madfu', 'madfuPaymentActivate'),
            Text::make('Madfu URL', 'madfu_url')->hideFromIndex(),
            Text::make('Madfu Username', 'madfu_userName')->hideFromIndex(),
            Text::make('Madfu Password', 'madfu_password')
                ->withMeta(['extraAttributes' => ['type' => 'password']])
                ->onlyOnForms(),
            Text::make('Madfu Authorization', 'madfu_Authorization')
                ->withMeta(['extraAttributes' => ['type' => 'password']])
                ->onlyOnForms(),
            Text::make('Madfu App Code', 'madfu_appcode')->hideFromIndex(),
            Text::make('Madfu API Key', 'madfu_apikey')
                ->withMeta(['extraAttributes' => ['type' => 'password']])
                ->onlyOnForms(),
            Text::make('Madfu Platform Type Id', 'madfu_PlatformTypeId')->hideFromIndex(),

            Heading::make('Amazon Payment Services'),
            Boolean::make('تفعيل Amazon', 'amazonPaymentActivate'),
            Text::make('Gateway Host', 'amazonGatewayHost')->hideFromIndex(),
            Text::make('Merchant Identifier', 'amazonMerchantIdentifier')->hideFromIndex(),
            Text::make('Access Code', 'amazonAccessCode')
                ->withMeta(['extraAttributes' => ['type' => 'password']])
                ->onlyOnForms(),
            Text::make('SHA Request Phrase', 'amazonSHARequestPhrase')
                ->withMeta(['extraAttributes' => ['type' => 'password']])
                ->onlyOnForms(),
            Text::make('SHA Response Phrase', 'amazonSHAResponsePhrase')
                ->withMeta(['extraAttributes' => ['type' => 'password']])
                ->onlyOnForms(),
            Text::make('SHA Type', 'amazonSHAType')->hideFromIndex(),
        ];
    }

    public function cards(Request $request)
    {
        return [];
    }
}
