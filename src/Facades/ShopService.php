<?php

namespace tanyudii\Laratok\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static object getShopInfo($shopId, array $payload = [])
 * @method static object updateShopStatus(array $payload = [])
 * @method static object getAllEtalase($shopId, array $payload = [])
 * @method static object getShowcaseByShopId($shopId, array $payload = [])
 * @method static object createShowcaseByShopId($shopId, array $payload)
 * @method static object updateShowcaseByShopId($shopId, array $payload)
 * @method static object deleteShowcaseByShopId($shopId, array $payload)
 *
 * @see \tanyudii\Laratok\Services\Tokopedia\Shop
 */
class ShopService extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return "laratok-shop-service";
    }
}
