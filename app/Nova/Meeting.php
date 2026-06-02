<?php

namespace App\Nova;


use Illuminate\Http\Request;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Heading;

use Laravel\Nova\Http\Requests\NovaRequest;

class Meeting extends Resource
{
    public static $canImportResource = false;
    public static $displayInNavigation = false;
    public static $globallySearchable = false;

    public static function authorizedToViewAny(Request $request)
    {
        return false;
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    
    public static $model = \App\JitsiMeeting::class;
    public static $group = ' الطلبات';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';
    public static function label()
    {
        return ('الفصول الإفتراضية');
    }

    public static function singularLabel()
    {
        return ('فصل إفتراضي');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'start_date',
        'title',
    ];

    public static $indexDefaultOrder = [
        'start_date' => 'desc'
    ];

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */

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

            Text::make('العنوان ', 'title')
                ->sortable()
                ->rules('required', 'max:255'),




            Text::make('التفاصيل', 'detils')
                ->rules('max:255'),

            Text::make(' رابط الاجتماع', 'meeting_url')
                ->rules('max:255')
                ->hideFromIndex(),
            DateTime::make('تاريخ البداية', 'start_date')
                ->hideFromIndex(),

            DateTime::make('تاريخ النهاية', 'end_date')
                ->hideFromIndex(),


            BelongsTo::make('تابع للعميل', 'customer', 'App\Nova\Customer')
                ->searchable()
                ->nullable(),
            BelongsTo::make('تابع للخدمة', 'service', 'App\Nova\Service')
                ->searchable()
                ->nullable(),
            BelongsTo::make('تابع لفاتورة الخدمة', 'serviceInvoiceItem', 'App\Nova\ServiceInvoiceItem')
                ->searchable()
                ->nullable(),
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
        return [];
    }
}
