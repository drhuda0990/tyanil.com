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

class Discount extends Resource
{
    public static $canImportResource = false;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Discount::class;
    public static $group = 'عام';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';
    public static function label()
    {
        return ('الكوبونات');
    }

    public static function singularLabel()
    {
        return ('كوبون');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'code',
        'title',
    ];

    public static $indexDefaultOrder = [
        'activate' => 'desc'
    ];

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        if (empty($request->get('orderBy'))) {
            $query->getQuery()->orders = [];
            return $query->orderBy(key(static::$indexDefaultOrder), reset(static::$indexDefaultOrder));
        }
        return $query;
    }
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

            Text::make('عنوان الخصم', 'title')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('كود الخصم', 'code')
                ->rules('required', 'max:255')
                ->help('يكتب الكود بالأحرف الصغيرة فقط')
                ->creationRules('unique:discounts,code')
                ->updateRules('unique:discounts,code,{{resourceId}}')
                ->withMeta($this->ID2 ? [] : ["value" => $this->generate_codes(6)])
                ->hideFromIndex()
                ->hideFromDetail()
                ->hideWhenUpdating(),

            Text::make('كود الخصم', 'code')
                ->rules('required', 'max:255')
                ->help('يكتب الكود بالأحرف الصغيرة فقط')
                ->creationRules('unique:discounts,code')
                ->updateRules('unique:discounts,code,{{resourceId}}')
                ->hideWhenCreating(),


            Text::make('توضيح الكود', 'slug')
                ->rules('max:255')
                ->hideFromIndex(),

            Number::make('نسبة الخصم %', 'discount')->min(0)->max(100)->step(1)
                ->rules('required')
                ->sortable(),

            // Number::make('تكرار الاستخدام', 'repetition')->min(0)->max(99)->step(1)
            //     ->rules('required')
            //     ->help('ضعه 0 في حال اردت لا نهائي')
            //     ->hideFromIndex(),

            DateTime::make('تاريخ البداية', 'date_1')
                ->hideFromIndex(),

            DateTime::make('تاريخ النهاية', 'date_2')
                ->hideFromIndex(),

            Boolean::make('تفعيل التاريخ', 'date_activate')

                ->help('لتفعيل تاريخ البداية والنهاية في الموقع او فقط عند التفعيل العام للخصم'),


            // BelongsTo::make('تابع للخدمة', 'service', 'App\Nova\Service')
            //     ->searchable()
            //     ->nullable()
            //     ->help('اتركه فارغ ان اردت للكل'),
            Boolean::make('تفعيل', 'activate'),
        ];
    }

    public  function generate_codes($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
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
