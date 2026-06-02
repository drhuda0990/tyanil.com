<?php

namespace App\Nova;

use App\Nova\Actions\PdfInvoice;
use Laravel\Nova\Fields\Image;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use app\Nova\Filters\FromFinancialDateFilters;
use app\Nova\Filters\ToDateFinancialFilters;

class ServiceInvoiceItem extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\ServiceInvoiceItem::class;
    public static $group = ' الطلبات';
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';
    public static function label()
    {
        return ('منتجات الفاتورة');
    }

    public static function singularLabel()
    {
        return ('منتج تابع لفاتورة');
    }
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
        'customer.name',
        'service.title'
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

            TextArea::make('التفاصيل من العميل', 'details')
                ->hideFromIndex(),

            // Text::make('المبلغ', 's_price')
            //     ->rules('required'),

            Trix::make('المرفقات من المشرف', 'admin_attachments')->withFiles()->disk('trix')->hideFromIndex(),
            Trix::make('رد المشرف', 'admin_response')->withFiles()->disk('trix')->hideFromIndex(),
            BelongsTo::make('الفاتورة', 'serviceInvoice', 'App\Nova\ServiceInvoice')->searchable(),
            BelongsTo::make('العميل', 'customer', 'App\Nova\Customer')->searchable(),
            BelongsTo::make('الخدمة', 'service', 'App\Nova\Service')->searchable(),
            Boolean::make('تفعيل', 'activate'),

            HasMany::make('المميزات الإضافيه', 'serInvoiceItemsFeatures', SerInvoiceItemsFeature::class),
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
        return [
            new FromFinancialDateFilters,
            new ToDateFinancialFilters,
        ];
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
        return [
            (new PdfInvoice()),
        ];
    }
}
