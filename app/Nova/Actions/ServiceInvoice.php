<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Http\Requests\NovaRequest;

class ServiceInvoice extends Action
{
  use InteractsWithQueue, Queueable;

  public function name()
  {
    return 'الفاتورة';
  }
  public $modelId;

  public function __construct($modelId)
  {
      $this->modelId = $modelId;
  }
  /**
   * Perform the action on the given models.
   *
   * @param  \Laravel\Nova\Fields\ActionFields  $fields
   * @param  \Illuminate\Support\Collection  $models
   * @return mixed
   */
  public function handle(ActionFields $fields, Collection $models)
  {

      // dd($fields,$models[0]->id);
    if (!$models[0]->id) {
      return Action::danger('عذراً الامتداد خاطئ !');
    } else {
      return  Action::redirect(route('admin.invoice', ['id' => encrypt($models[0]->id),'detail'=>$fields->details_invoice]));
    }
  }


  /**
   * Get the fields available on the action.
   *
   * @return array
   */
  public function fields(NovaRequest $request)
  {
    return [
      Boolean::make(' فاتورة مفصلة', 'details_invoice'),
    ];
  }
  
}
