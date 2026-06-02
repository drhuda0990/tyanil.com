<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Fields\Boolean;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Heading;
use Session;
use Laravel\Nova\Http\Requests\NovaRequest;

class PdfInvoice extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $withoutActionEvents = true;
    public function name()
    {
        return 'تصدير ل pdf';
    }
    public $mfields;


    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $mfields = $this->mfields;
        $ides = [];
        Session::put('invoice_fields', $fields);
        Session::put('invoice_data', $models->pluck('id'));
        Session::save();
        return  Action::redirect(route("admin.pdfInvoice", ['invoices' => encrypt($mfields)]));
    }


    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(NovaRequest $request = null)
    {
        $filters = null;
        if ($request->has('filters')) {
            // Get the decoded list of filters
            $filters = json_decode(base64_decode($request->filters), true);
        }
        $this->mfields = $filters;
        return [
            Boolean::make('تصدير جميع السندات حسب القيم المحدده في الفلتر', 'all_filter_data'),
            Boolean::make('تصدير القيم المحدده فقط', 'selected_data'),
        ];
    }
}