<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;

class Message extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Message::class;
    public static $group = 'عام';
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';
    public static function label()
    {
        return ('سجل الرسائل');
    }

    public static function singularLabel()
    {
        return ('رسالة');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title','sender_has'
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

            Text::make('العنوان','title'),

            Text::make('الرسالة','message')
                ->hideFromIndex(),

            Text::make('القسم','section')
                ->hideFromIndex(),

            Text::make('المرسل','sender')
                ->hideFromIndex(),

            Text::make('المرسل له','sender_has'),

            Text::make('json','json')
                ->hideFromIndex(),

            Text::make('بتاريخ','sent_at'),

            Select::make('النوع', 'type')->options([
              '1' => 'SMS',
              '2' => 'Whatsapp',
              '3' => 'Email',
            ])
            ->displayUsingLabels(),

            Boolean::make('الحالة', 'state'),

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



    /*------------*/
    //public static $displayInNavigation = false;

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    public static function searchable()
    {
        return true;
    }


}
