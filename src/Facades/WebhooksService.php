<?php

namespace tanyudii\Laratok\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static object listRegisteredWebhooks()
 * @method static object register(array $payload)
 * @method static object getWebhookPayload($orderId, $type)
 * @method static object triggerWebhook(array $payload)
 *
 * @see \tanyudii\Laratok\Services\Tokopedia\Webhooks
 */
class WebhooksService extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return "laratok-webhooks-service";
    }
}
