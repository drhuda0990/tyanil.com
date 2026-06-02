<?php

namespace App\Nova\Metrics;

use App\ServiceInvoice;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class StoreRevenue extends Value
{
    public function name()
    {
        return 'إجمالي المبيعات';
    }

    public function calculate(NovaRequest $request)
    {
        return $this->sum($request, ServiceInvoice::class, 'amount')
            ->format('0,0.00')
            ->suffix(' SAR');
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
        return 'store-revenue';
    }
}
