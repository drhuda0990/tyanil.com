<?php

// namespace App\Nova;

// use Illuminate\Http\Request;
// use Laravel\Nova\Fields\ID;
// use Laravel\Nova\Fields\Text;
// use Laravel\Nova\Fields\Trix;
// use Laravel\Nova\Fields\DateTime;
// use Laravel\Nova\Fields\Boolean;
// use Laravel\Nova\Fields\Textarea;
// use Laravel\Nova\Fields\Image;
// use Laravel\Nova\Fields\BelongsTo;
// use Outl1ne\MultiselectField\Multiselect;
// use Laravel\Nova\Http\Requests\NovaRequest;

// class Permission extends Resource
// {
    // /**
    //  * The model the resource corresponds to.
    //  *
    //  * @var string
    //  */
    // public static $model = \App\Permission::class;

    // public static $group = 'عام';


    // /**
    //  * The single value that should be used to represent the resource when being displayed.
    //  *
    //  * @var string
    //  */
    // public static $title = 'name';
    // public static function label()
    // {
    //     return (' الصلاحيات');
    // }
    // public static function indexQuery(NovaRequest $request, $query)
    // {
    //     // nova permission have type 1 
    //     //account permission have type 2
    //     //nova & account permission have type 3
    //     return $query->where('type','=',1)->orWhere('type','=',3);
    // }

    // public static function singularLabel()
    // {
    //     return ('صلاحية');
    // }

    // /**
    //  * The columns that should be searched.
    //  *
    //  * @var array
    //  */
    // public static $search = [
    //     'name',
    // ];

    // /**
    //  * Get the fields displayed by the resource.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return array
    //  */
    // public function fields(Request $request)
    // {
    //     return [
    //         ID::make()->sortable(),

    //         Text::make('الاسم','name')
    //             ->sortable()
    //             ->rules('required', 'max:255'),

    //         Text::make('الاسم البرمجي', 'guard_name')
    //         ->rules('required')
    //             ->creationRules('unique:permissions,guard_name')
    //             ->updateRules('unique:permissions,guard_name,{{resourceId}}'),



    //     ];
    // }

    // /**
    //  * Get the cards available for the request.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return array
    //  */
    // public function cards(Request $request)
    // {
    //     return [];
    // }

    // /**
    //  * Get the filters available for the resource.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return array
    //  */
    // public function filters(Request $request)
    // {
    //     return [];
    // }

    // /**
    //  * Get the lenses available for the resource.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return array
    //  */
    // public function lenses(Request $request)
    // {
    //     return [];
    // }

    // /**
    //  * Get the actions available for the resource.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return array
    //  */
    // public function actions(Request $request)
    // {
    //     return [];
    // }
    // public function authorizedToDelete(Request $request)
    // {
    //     return false;
    // }

    // public function authorizedToUpdate(Request $request)
    // {
    //     return false;
    // }

// }
