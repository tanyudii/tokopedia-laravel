<?php

namespace tanyudii\Laratok\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \tanyudii\Laratok\Services\Tokopedia\Finance
 */
class FinanceService extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return "laratok-finance-service";
    }
}
