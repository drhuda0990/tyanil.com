<?php

namespace App\Nova;

use Laravel\Nova\Fields\Image;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use AlexAzartsev\Heroicon\Heroicon;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class ServiceCategory extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\ServiceCategory::class;
    public static $group = 'المنتجات والمتجر';
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';
    public static function label()
    {
        return ('تصنيفات المنتجات');
    }

    public static function singularLabel()
    {
        return ('تصنيف منتج');
    }
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
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

            Text::make('الاسم', 'title')
                ->sortable()
                ->rules('required', 'max:255'),
            Image::make('الصورة', 'image')
                ->disk('public'),
                Heroicon::make('الايقونة','icon')
,               
            Text::make('التفاصيل', 'details')
                ->sortable()
                ->hideFromIndex(),
            Text::make('اسم المعرف باللغة الانجليزيه', 'slug')
                ->sortable()
                ->creationRules('unique:service_categories,slug')
                ->updateRules('unique:service_categories,slug,{{resourceId}}'),
            Number::make('ترتيب القسم في الرئيسية  ', 'order_num')->min(1)
                ->hideFromIndex(),

            Boolean::make('هل هذه التقسيمة رئيسية', 'main_category')
                ->help('لا يتم تفعيلة في حال كانت التقسيمةفرعية ويترك حقل "يتبع التقسيمة الرئيسة" فارغاً في حل تم تفعيله'),
            Select::make('يتبع التقسيمة الرئيسية', 'parent_main_category_id')
                ->options(\App\ServiceCategory::where('main_category', '=', 1)
                    ->pluck('title', 'id'))
                ->searchable()
                ->nullable()
                ->displayUsingLabels(),
            Boolean::make('تفعيل', 'activate'),
            HasMany::make(' التقسيمات الفرعية ', 'serviceSubCategories', ServiceCategory::class),
            HasMany::make('الخدمات التابعه للقسم', 'services', Service::class),






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
