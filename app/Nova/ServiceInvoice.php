<?php

namespace App\Nova;

use Google\Service\MyBusinessBusinessInformation\ServiceItem;
use Laravel\Nova\Fields\Image;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class ServiceInvoice extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\ServiceInvoice::class;
    public static $group = ' الطلبات';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */

    public function title()
    {
        $return_text = $this->id . " | " . $this->title . " | " . $this->customer->name;
        return $return_text;
    }
    public static function label()
    {
        return ('طلبات وفواتير المتجر');
    }

    public static function singularLabel()
    {
        return ('طلب | فاتورة');
    }
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
        'customer.name',
        'discount.code'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('العنوان', 'title')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('الملاحظة', 'note')
                ->hideFromIndex(),

            Text::make('المبلغ', 'amount')
                ->rules('required'),
            Text::make('الكود', 'discount_code'),

            Text::make('قيمة الخصم', 'discount'),
            Text::make('قيمة الشحن', 'shipment_price'),
            Text::make('الاسم في عنوان الشحن ', 'name')
                ->hideFromIndex(),
            Text::make('الجوال في عنوان الشحن ', 'phone')
                ->hideFromIndex(),
            Text::make('الايميل في عنوان الشحن', 'email')
                ->hideFromIndex(),
            Text::make('مدينة الشحن', 'city')
                ->hideFromIndex(),

            Text::make('عنوان الشحن', 'address')
                ->hideFromIndex(),
            Text::make(' حي الشحن', 'street')
                ->hideFromIndex(),



            Select::make('طريقة الدفع', 'method')
                ->options(\App\Definition::where('type_id', '=', 4)
                    ->pluck('name', 'id'))
                ->searchable()
                ->displayUsingLabels(),
            Boolean::make('تفعيل', 'activate'),
            BelongsTo::make('العميل', 'customer', 'App\Nova\Customer')->searchable(),
            BelongsTo::make('كود الخصم', 'discount', 'App\Nova\Discount')->nullable()->searchable(),
            HasMany::make('الخدمات المطلوبة بالفاتورة', 'serviceItems', ServiceInvoiceItem::class),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return
            [(new Actions\ServiceInvoice($request))
                ->onlyOnTableRow()
                ->confirmText('هل أنت متأكد من الانتقال إلى الصفحة المحددة')
                ->confirmButtonText('انتقال')
                ->cancelButtonText("إلغاء الأمر"),];
    }
}