<?php

namespace tanyudii\Laratok\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \tanyudii\Laratok\Services\Tokopedia\Campaign
 */
class CampaignService extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return "laratok-campaign-service";
    }
}
