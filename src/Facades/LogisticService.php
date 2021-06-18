<?php

namespace tanyudii\Laratok\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \tanyudii\Laratok\Services\Tokopedia\Logistic
 */
class LogisticService extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return "laratok-logistic-service";
    }
}
