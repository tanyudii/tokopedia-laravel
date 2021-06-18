<?php

namespace tanyudii\Laratok\Services\Tokopedia;

use Illuminate\Support\Arr;
use tanyudii\Laratok\Services\AbstractService;

class Webhooks extends AbstractService
{
    /**
     * @return string
     */
    public function listRegisteredWebhooks()
    {
        $response = $this->http()->get(
            sprintf("/v1/fs/%s", $this->getCredential()->getFsId())
        );

        return $response->object() ?: $response->body();
    }

    /**
     * @param array $payload
     * @return object|string
     */
    public function register(array $payload)
    {
        $response = $this->http()->post(
            sprintf("/v1/fs/%s/register", $this->getCredential()->getFsId()),
            Arr::only($payload, [
                "fs_id",
                "order_notification_url",
                "order_cancellation_url",
                "order_status_url",
                "chat_notification_url",
                "product_creation_url",
                "product_changes_url",
                "campaign_notification_url",
                "webhook_secret",
            ])
        );

        return $response->object() ?: $response->body();
    }

    /**
     * @param $orderId
     * @param $type
     * @return object|string
     */
    public function getWebhookPayload($orderId, $type)
    {
        $response = $this->http()->get(
            sprintf(
                "/v1/order/%s/fs/%s/webhook?type=%s",
                $orderId,
                $this->getCredential()->getFsId(),
                $type
            )
        );

        return $response->object() ?: $response->body();
    }

    /**
     * @param array $payload
     * @return object|string
     */
    public function triggerWebhook(array $payload)
    {
        $response = $this->http()->post(
            sprintf("/v1/fs/%s/trigger", $this->getCredential()->getFsId()),
            Arr::only($payload, ["order_id", "type", "url", "is_encrypted"])
        );

        return $response->object() ?: $response->body();
    }
}
