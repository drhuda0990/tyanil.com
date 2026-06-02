<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class NotificationSetting extends Resource
{
    public static $model = \App\GeneralSetting::class;
    public static $title = 'name';
    public static $group = 'مركز الإشعارات';
    public static $search = ['id', 'name'];

    public static function label()
    {
        return 'إعدادات الإشعارات';
    }

    public static function singularLabel()
    {
        return 'إعداد الإشعارات';
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Heading::make('الإشعارات الداخلية'),
            Boolean::make('تفعيل الإشعارات الداخلية', 'internalNotificationsActivate'),
            Boolean::make('إشعارات الطلبات', 'orderNotificationsActivate'),
            Boolean::make('إشعارات رسائل التواصل', 'contactNotificationsActivate'),
            Boolean::make('إشعارات العملاء', 'customerNotificationsActivate'),
            Boolean::make('إشعارات المخزون والتنبيهات التشغيلية', 'inventoryNotificationsActivate'),

            Heading::make('قنوات التنبيه الخارجية'),
            Boolean::make('تفعيل البريد للإشعارات', 'emailNotificationsActivate'),
            Boolean::make('تفعيل SMS للإشعارات', 'smsNotificationsActivate'),
            Text::make('بريد الإدارة', 'admin_notification_email')->hideFromIndex(),
            Text::make('جوال الإدارة', 'admin_notification_phone')->hideFromIndex(),
        ];
    }
}
