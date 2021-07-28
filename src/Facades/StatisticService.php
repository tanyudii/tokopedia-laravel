<?php

namespace tanyudii\Laratok\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static object getShopPerformance($shopId, $startDate, $endDate)
 * @method static object getProductStatistics($shopId, $startDate, $endDate, $pageSize)
 * @method static object getTransactionStatistics($shopId, $startDate, $endDate, array $payload)
 * @method static object getBuyerStatistics($shopId, $startDate, $endDate, $payload)
 *
 * @see \tanyudii\Laratok\Services\Tokopedia\Statistic
 */
class StatisticService extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return "laratok-statistic-service";
    }
}
