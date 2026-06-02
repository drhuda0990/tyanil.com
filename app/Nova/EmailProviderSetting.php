<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class EmailProviderSetting extends Resource
{
    public static $model = \App\GeneralSetting::class;
    public static $title = 'name';
    public static $group = 'التكاملات والإعدادات';
    public static $search = ['id', 'name'];

    public static function label()
    {
        return 'مزود البريد الإلكتروني';
    }

    public static function singularLabel()
    {
        return 'إعداد البريد الإلكتروني';
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Heading::make('إعدادات الإرسال'),
            Boolean::make('تفعيل إشعارات البريد', 'emailNotificationsActivate'),
            Select::make('مزود البريد', 'mail_provider')
                ->options([
                    'log' => 'Log محلي',
                    'smtp' => 'SMTP',
                    'mailgun' => 'Mailgun',
                    'ses' => 'Amazon SES',
                ])
                ->displayUsingLabels(),
            Text::make('MAIL_MAILER', 'MAIL_MAILER')->hideFromIndex(),
            Text::make('MAIL_FROM_NAME', 'MAIL_FROM_NAME')->hideFromIndex(),
            Text::make('MAIL_FROM_ADDRESS', 'MAIL_FROM_ADDRESS')->hideFromIndex(),
            Text::make('بريد تنبيهات الإدارة', 'admin_notification_email')->hideFromIndex(),

            Heading::make('SMTP'),
            Text::make('MAIL_HOST', 'MAIL_HOST')->hideFromIndex(),
            Text::make('MAIL_PORT', 'MAIL_PORT')->hideFromIndex(),
            Text::make('MAIL_USERNAME', 'MAIL_USERNAME')->hideFromIndex(),
            Text::make('MAIL_PASSWORD', 'MAIL_PASSWORD')
                ->withMeta(['extraAttributes' => ['type' => 'password']])
                ->onlyOnForms(),
            Text::make('MAIL_ENCRYPTION', 'MAIL_ENCRYPTION')->hideFromIndex(),

            Heading::make('Mailgun'),
            Text::make('MAILGUN_DOMAIN', 'MAILGUN_DOMAIN')->hideFromIndex(),
            Text::make('MAILGUN_SECRET', 'MAILGUN_SECRET')
                ->withMeta(['extraAttributes' => ['type' => 'password']])
                ->onlyOnForms(),
        ];
    }
}
