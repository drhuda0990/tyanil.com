<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class SmsProviderSetting extends Resource
{
    public static $model = \App\GeneralSetting::class;
    public static $title = 'name';
    public static $group = 'التكاملات والإعدادات';
    public static $search = ['id', 'name'];

    public static function label()
    {
        return 'مزود الرسائل النصية';
    }

    public static function singularLabel()
    {
        return 'إعداد الرسائل النصية';
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Heading::make('إعدادات SMS'),
            Boolean::make('تفعيل إشعارات SMS', 'smsNotificationsActivate'),
            Select::make('مزود الرسائل', 'sms_provider')
                ->options([
                    '4jawaly' => '4Jawaly',
                    'unifonic' => 'Unifonic',
                    'taqnyat' => 'Taqnyat',
                    'mock' => 'محلي / تجريبي',
                ])
                ->displayUsingLabels(),
            Text::make('رقم تنبيهات الإدارة', 'admin_notification_phone')->hideFromIndex(),

            Heading::make('4Jawaly'),
            Text::make('App Id', 'sender_user')->hideFromIndex(),
            Text::make('App Secret', 'sender_password')
                ->withMeta(['extraAttributes' => ['type' => 'password']])
                ->onlyOnForms(),
            Text::make('Sender Name', 'sender_name')->hideFromIndex(),
        ];
    }
}
