<?php

namespace App\Nova;

use Illuminate\Http\Request;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\HasMany;


use Illuminate\Support\Facades\Storage;

use Laravel\Nova\Http\Requests\NovaRequest;

class Post extends Resource
{
    public static $canImportResource = false;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Post::class;

    public static $group = 'عام';


    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */

    public static $title = 'title';

    public static function label()
    {
        return ('المقالات');
    }

    public static function singularLabel()
    {
        return ('مقالة');
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

            Text::make('عنوان المقالة', 'title')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('الدليل', 'slug')
                ->hideFromIndex(),

            Textarea::make('ملحص', 'summary')
                ->hideFromIndex(),

            Trix::make('المقالة', 'body')->withFiles('public')
                ->hideFromIndex(),


            Image::make('الصورة الأساسية', 'images')
                ->disk('public'),

            Select::make('النوع', 'type')->options([
                '1' => 'صفحة',
                '2' => 'مقالة',
                '3' => 'تدوينة',
                '4' => 'خبر',
            ])
                ->rules('required')
                ->displayUsingLabels(),

            BelongsTo::make('الكاتب', 'user', 'App\Nova\User')->rules('required'),
            DateTime::make('النشر بتاريخ', 'publish_at')
                ->help('التلقائي النشر فوراً'),

            // Boolean::make('السماح للتعليقات', 'comments')
            //     ->hideFromIndex(),

            Boolean::make('نشر', 'is_published'),

           
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
