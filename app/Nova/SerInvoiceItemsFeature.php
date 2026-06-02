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

class SerInvoiceItemsFeature extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\SerInvoiceItemsFeature::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    public static $group = ' الطلبات';
    public static $displayInNavigation = false;

    public static function label()
    {
        return ('الخيارات الإضافية للمنتجات');
    }
    

    public static function singularLabel()
    {
        return ('الميزة الإضافية');
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

            Text::make('التفاصيل', 'details')
                ->sortable(),

            Text::make('السعر ', 'price')
                ->rules('required'),
            BelongsTo::make('الخدمة', 'service', 'App\Nova\Service'),

            // Boolean::make('ميزة تحتاج لشحن', 'required_shipment'),
            Boolean::make('تفعيل', 'activate'),

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
