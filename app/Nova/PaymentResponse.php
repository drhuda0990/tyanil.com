<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class PaymentResponse extends Resource
{
    public static $model = \App\PaymentResponse::class;
    public static $title = 'payment_id';
    public static $group = 'الطلبات والمدفوعات';
    public static $search = ['id', 'payment_id', 'customer_id', 'payment_type', 'status'];

    public static function label()
    {
        return 'استجابات الدفع';
    }

    public static function singularLabel()
    {
        return 'استجابة دفع';
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Payment ID', 'payment_id')->sortable(),
            Text::make('النوع', 'payment_type')->sortable(),
            Text::make('الحالة', 'status')->sortable(),
            Number::make('المبلغ', 'amount')->step(0.01)->sortable(),
            Text::make('Customer ID', 'customer_id')->hideFromIndex(),
            Text::make('Cart IDs', 'cart_ids')->hideFromIndex(),
            Text::make('Discount ID', 'discount_id')->hideFromIndex(),
            Text::make('Payment URL', 'payment_url')->hideFromIndex(),
            Textarea::make('Request', 'request')->hideFromIndex(),
            Textarea::make('Response', 'response')->hideFromIndex(),
            DateTime::make('تاريخ الإنشاء', 'created_at')->exceptOnForms(),
        ];
    }
}
