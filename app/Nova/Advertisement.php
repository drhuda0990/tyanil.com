<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\MorphToMany;
use Outl1ne\MultiselectField\Multiselect;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Trix;

class Advertisement extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Advertisement::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    public static $group = 'عام';

    public static function label()
    {
        return ('الإعلانات');
    }

    public static function singularLabel()
    {
        return ('الإعلانات');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
        'details',
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
            Image::make('الصورة الأساسية', 'image')
                ->disk('public'),
            Text::make('الرابط', 'url')
                ->sortable(),
            Trix::make('التفاصيل', 'details')
                ->sortable(),
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

    public function getPermissions()
    {
        $items =  \App\Permission::all();
        $data = null;
        foreach ($items as $item) {
            $data[$item->id] = $item->name;
        }

        return $data;
    }
}
