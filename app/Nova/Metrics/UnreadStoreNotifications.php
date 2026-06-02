<?php

namespace App\Nova\Metrics;

use App\StoreNotification;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class UnreadStoreNotifications extends Value
{
    public function name()
    {
        return 'الإشعارات غير المقروءة';
    }

    public function calculate(NovaRequest $request)
    {
        return $this->count($request, StoreNotification::unread());
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
        return 'unread-store-notifications';
    }
}
