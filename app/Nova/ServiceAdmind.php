<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\MorphToMany;
use Outl1ne\MultiselectField\Multiselect;

class ServiceAdmind extends Resource
{
    public static $canImportResource = false;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\ServiceAdmind::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public static $group = 'المستخدمين';

    public static function label()
    {
        return ('مشرفي الخدمات');
    }

    public static function singularLabel()
    {
        return ('مشرف');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
        'email',
        'phone'
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

            Gravatar::make()->maxWidth(50),

            //Text::make('Name')
            Text::make('الاسم', 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('البريد الإلكتروني', 'email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:service_adminds,email')
                ->updateRules('unique:service_adminds,email,{{resourceId}}'),
            Text::make('رقم الهاتف ', 'phone')
                ->sortable()
                ->rules('required')
                ->creationRules('unique:service_adminds,phone')
                ->updateRules('unique:service_adminds,phone,{{resourceId}}'),
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
