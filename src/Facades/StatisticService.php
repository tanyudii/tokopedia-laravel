<?php

namespace tanyudii\Laratok\Facades;

use Illuminate\Support\Facades\Facade;

/**
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
