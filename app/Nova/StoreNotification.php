<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class StoreNotification extends Resource
{
    public static $model = \App\StoreNotification::class;
    public static $title = 'title_ar';
    public static $group = 'مركز الإشعارات';
    public static $search = ['id', 'title_ar', 'body_ar', 'type', 'status'];

    public static function label()
    {
        return 'الإشعارات الداخلية';
    }

    public static function singularLabel()
    {
        return 'إشعار داخلي';
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Select::make('الجمهور', 'audience')
                ->options([
                    'admin' => 'الإدارة',
                    'customer' => 'عميل',
                    'all' => 'الكل',
                ])
                ->displayUsingLabels()
                ->sortable(),
            Select::make('النوع', 'type')
                ->options([
                    'general' => 'عام',
                    'order_created' => 'طلب جديد',
                    'contact_created' => 'رسالة تواصل',
                    'service_item_updated' => 'تحديث طلب',
                    'payment' => 'دفع',
                    'inventory' => 'مخزون',
                ])
                ->displayUsingLabels(),
            Select::make('الأولوية', 'priority')
                ->options([
                    'low' => 'منخفضة',
                    'normal' => 'عادية',
                    'high' => 'مرتفعة',
                    'critical' => 'حرجة',
                ])
                ->displayUsingLabels()
                ->sortable(),
            Select::make('الحالة', 'status')
                ->options([
                    'unread' => 'غير مقروء',
                    'read' => 'مقروء',
                    'archived' => 'مؤرشف',
                ])
                ->displayUsingLabels()
                ->sortable(),
            BelongsTo::make('مستخدم الإدارة', 'user', User::class)->nullable()->hideFromIndex(),
            BelongsTo::make('العميل', 'customer', Customer::class)->nullable()->hideFromIndex(),
            BelongsTo::make('الفاتورة', 'serviceInvoice', ServiceInvoice::class)->nullable()->hideFromIndex(),
            BelongsTo::make('رسالة التواصل', 'contact', Contact::class)->nullable()->hideFromIndex(),
            Text::make('العنوان', 'title_ar')->rules('required', 'max:255')->sortable(),
            Text::make('العنوان EN', 'title_en')->hideFromIndex(),
            Textarea::make('النص', 'body_ar')->hideFromIndex(),
            Textarea::make('النص EN', 'body_en')->hideFromIndex(),
            Text::make('رابط الإجراء', 'action_url')->hideFromIndex(),
            Code::make('القنوات', 'channels')->json()->hideFromIndex(),
            Code::make('البيانات', 'data')->json()->hideFromIndex(),
            DateTime::make('وقت القراءة', 'read_at')->nullable()->hideFromIndex(),
            DateTime::make('وقت الإرسال', 'sent_at')->nullable()->hideFromIndex(),
            DateTime::make('تاريخ الإنشاء', 'created_at')->exceptOnForms(),
        ];
    }
}
