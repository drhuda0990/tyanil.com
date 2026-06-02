<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

class Rating extends Resource
{
    public static $canImportResource = false;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Rating::class;
    public static $group = 'المنتجات والمتجر';
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';
    public static function label()
    {
        return ('تقييمات الخدمات ');
    }

    public static function singularLabel()
    {
        return (' تقييم الخدمة');
    }
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [

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
            BelongsTo::make('العميل', 'customer', Customer::class)
                  ->searchable()
                  ->sortable()
                  ->rules('required'),
            BelongsTo::make('الخدمة', 'service', Service::class)
                  ->searchable()
                  ->sortable()
                  ->rules('required'),           
            Boolean::make('إظهارالتعليق في الصفحة الرئيسية ','appear_inHome'),
            Number::make(' عدد النجوم','stars')
                ->sortable(), 
             Text::make(' التقييم', 'comment'),
             Boolean::make('إظهار التعليق ','status')
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
