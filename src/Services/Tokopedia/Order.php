<?php

namespace tanyudii\Laratok\Services\Tokopedia;

use Illuminate\Support\Arr;
use tanyudii\Laratok\Services\AbstractService;

class Order extends AbstractService
{
    /**
     * @param $fromDate
     * @param $toDate
     * @param $page
     * @param $perPage
     * @param array $payload
     * @return string
     */
    public function getAllOrders(
        $fromDate,
        $toDate,
        $page,
        $perPage,
        array $payload = []
    ) {
        $response = $this->http()->get(
            sprintf(
                "/v2/order/list?fs_id=%s&from_date=%s&to_date=%s&page=%s&per_page=%s&%s",
                $this->getCredential()->getFsId(),
                $fromDate,
                $toDate,
                $page,
                $perPage,
                http_build_query(
                    Arr::only($payload, ["shop_id", "warehouse_id", "status"])
                )
            )
        );

        return $this->handleResponse($response);
    }

    /**
     * @param array $payload
     * @return string
     */
    public function getSingleOrder(array $payload = [])
    {
        $response = $this->http()->get(
            sprintf(
                "/v2/fs/%s/order?%s",
                $this->getCredential()->getFsId(),
                http_build_query(
                    Arr::only($payload, ["order_id", "invoice_num"])
                )
            )
        );

        return $this->handleResponse($response);
    }

    /**
     * @param $orderId
     * @return string
     */
    public function acceptOrder($orderId)
    {
        $response = $this->http()->post(
            sprintf(
                "/v1/order/%s/fs/%s/ack",
                $orderId,
                $this->getCredential()->getFsId()
            )
        );

        return $this->handleResponse($response);
    }
}
