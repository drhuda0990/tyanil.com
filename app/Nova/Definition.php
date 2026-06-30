<?php

namespace App\Nova;

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

class Definition extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Definition::class;
    public static $group = 'عام';
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';
    public static function label()
    {
        return ('تعريفات');
    }

    public static function singularLabel()
    {
        return ('تعريف');
    }
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name', 'type_id'
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

            Text::make('الاسم', 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('الدليل', 'slug')
                ->rules('max:255')
                ->hideFromIndex(),


            Text::make('الايقونة', 'icon')
                ->rules('max:255')
                ->hideFromIndex(),

            Trix::make('المحتوى', 'content')
                ->hideFromIndex(),

            Select::make('النوع', 'type_id')
                ->options([
                    '1' => 'رسالة شراء خدمة',
                    '2' => 'تعليمات وأنظمة',
                    '3' => 'حالة الخدمة المقدمة',
                    '4' => 'طريقة الدفع',
                    '5' => 'نوع من انواع توصل معنا',
                    '8' => 'رسائل المتجر والبريد',
                ])
                ->rules('required')
                ->displayUsingLabels(),

                Select::make('المستخدم' , 'user_id')
                ->options(\App\User::where('id', '=', auth()->id())
                //->options(\App\User::get()
                  ->pluck('name', 'id')
                )
                
                ->rules('required')
                ->displayUsingLabels()
                  ->hideFromIndex(),
            Boolean::make('تفعيل', 'activate'),


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
