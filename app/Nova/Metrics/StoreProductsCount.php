<?php

namespace App\Nova\Metrics;

use App\Service;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class StoreProductsCount extends Value
{
    public function name()
    {
        return 'المنتجات النشطة';
    }

    public function calculate(NovaRequest $request)
    {
        return $this->count($request, Service::where('activate', 1));
    }

    public function ranges()
    {
        return [
            30 => '30 يوم',
            60 => '60 يوم',
            365 => 'سنة',
            'TODAY' => 'اليوم',
            'MTD' => 'هذا الشهر',
            'YTD' => 'هذه السنة',
        ];
    }

    public function uriKey()
    {
        return 'store-products-count';
    }
}
