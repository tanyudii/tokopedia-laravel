<?php

namespace tanyudii\Laratok\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static object getAllOrders($fromDate, $toDate, $page, $perPage, array $payload = [])
 * @method static object getSingleOrder(array $payload = [])
 * @method static object acceptOrder($orderId)
 *
 * @see \tanyudii\Laratok\Services\Tokopedia\Order
 */
class OrderService extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return "laratok-order-service";
    }
}
