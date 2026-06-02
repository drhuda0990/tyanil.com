<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Dashboards\Main as Dashboard;
use App\Nova\Metrics\StoreCustomersCount;
use App\Nova\Metrics\StoreOrdersCount;
use App\Nova\Metrics\StoreProductsCount;
use App\Nova\Metrics\StoreRevenue;
use App\Nova\Metrics\UnreadStoreNotifications;
class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            new StoreRevenue,
            new StoreOrdersCount,
            new StoreCustomersCount,
            new StoreProductsCount,
            new UnreadStoreNotifications,
        ];
    }
}
