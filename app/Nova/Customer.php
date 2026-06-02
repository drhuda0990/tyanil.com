<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;

use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\MorphToMany;
use Outl1ne\MultiselectField\Multiselect;

class Customer extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Customer::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public static $group = 'المستخدمين';

    public static function label()
    {
        return (' عملائنا');
    }

    public static function singularLabel()
    {
        return ('عميل');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
        'name_en',
        'identity',
        'phone',
        'email',
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

            Text::make('الاسم', 'name')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('name en', 'name_en')
                ->sortable()
                ->rules('max:255'),

            Text::make('البريد الإلكتروني', 'email')
                ->sortable()
                ->rules('max:254')
                ->creationRules('unique:customers,email')
                ->updateRules('unique:customers,email,{{resourceId}}'),
            Text::make(' الجوال', 'phone')
                ->sortable()
                ->rules('required', 'max:254')
                ->creationRules('unique:customers,phone')
                ->updateRules('unique:customers,phone,{{resourceId}}'),

            Password::make('كلمة المرور', 'Password')
                ->onlyOnForms(),
            Boolean::make('تفعيل', 'activate'),
            HasMany::make('طلبات الخدمة', 'services', ServiceInvoiceItem::class),
            HasMany::make('فواتير الخدمات', 'serviceInvoices', ServiceInvoice::class),


            //*********************************


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
        return [
            Actions\SendEmail::make()->standalone(),
        ];
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
