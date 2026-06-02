<?php

namespace App\Nova\Metrics;

use App\ServiceInvoice;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class StoreOrdersCount extends Value
{
    public function name()
    {
        return 'عدد الطلبات';
    }

    public function calculate(NovaRequest $request)
    {
        return $this->count($request, ServiceInvoice::class);
    }

    public function ranges()
    {
        return [
            'TODAY' => 'اليوم',
            7 => '7 أيام',
            30 => '30 يوم',
            60 => '60 يوم',
            365 => 'سنة',
            'MTD' => 'هذا الشهر',
            'YTD' => 'هذه السنة',
        ];
    }

    public function uriKey()
    {
        return 'store-orders-count';
    }
}
