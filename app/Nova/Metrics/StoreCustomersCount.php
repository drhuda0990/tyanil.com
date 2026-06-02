<?php

namespace App\Nova\Metrics;

use App\Customer;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class StoreCustomersCount extends Value
{
    public function name()
    {
        return 'العملاء';
    }

    public function calculate(NovaRequest $request)
    {
        return $this->count($request, Customer::class);
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
        return 'store-customers-count';
    }
}
