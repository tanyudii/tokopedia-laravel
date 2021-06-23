<?php

namespace tanyudii\Laratok\Services\Tokopedia;

use Illuminate\Support\Arr;
use tanyudii\Laratok\Services\AbstractService;

class Shop extends AbstractService
{
    /**
     * @param $shopId
     * @param array $payload
     * @return string
     */
    public function getShopInfo($shopId, array $payload = [])
    {
        $response = $this->http()->get(
            sprintf(
                "/v1/shop/fs/%s/shop-info?shop_id=%s&%s",
                $this->getCredential()->getFsId(),
                $shopId,
                http_build_query(Arr::only($payload, ["page", "per_page"]))
            )
        );

        return $this->handleResponse($response);
    }

    /**
     * @param array $payload
     * @return string
     */
    public function updateShopStatus(array $payload = [])
    {
        $response = $this->http()->post(
            sprintf(
                "/v2/shop/fs/%s/shop-status",
                $this->getCredential()->getFsId()
            ),
            Arr::only($payload, [
                "shop_id",
                "action",
                "start_date",
                "end_date",
                "close_note",
                "close_now",
            ])
        );

        return $this->handleResponse($response);
    }

    /**
     * @param $shopId
     * @param array $payload
     * @return string
     */
    public function getAllEtalase($shopId, array $payload = [])
    {
        $response = $this->http()->get(
            sprintf(
                "/inventory/v1/fs/%s/product/etalase?shop_id=%s&%s",
                $this->getCredential()->getFsId(),
                $shopId,
                http_build_query(Arr::only($payload, []))
            )
        );

        return $this->handleResponse($response);
    }

    /**
     * @param $shopId
     * @param array $payload
     * @return string
     */
    public function getShowcaseByShopId($shopId, array $payload = [])
    {
        $response = $this->http()->get(
            sprintf(
                "/v1/showcase/fs/%s/get?shop_id=%s&%s",
                $this->getCredential()->getFsId(),
                $shopId,
                http_build_query(
                    Arr::only($payload, [
                        "page",
                        "page_count",
                        "hide_zero",
                        "display",
                    ])
                )
            )
        );

        return $this->handleResponse($response);
    }

    /**
     * @param $shopId
     * @param array $payload
     * @return string
     */
    public function createShowcaseByShopId($shopId, array $payload)
    {
        $response = $this->http()->post(
            sprintf(
                "/v1/showcase/fs/%s/create?shop_id=%s",
                $this->getCredential()->getFsId(),
                $shopId
            ),
            Arr::only($payload, ["name"])
        );

        return $this->handleResponse($response);
    }

    /**
     * @param $shopId
     * @param array $payload
     * @return string
     */
    public function updateShowcaseByShopId($shopId, array $payload)
    {
        $response = $this->http()->patch(
            sprintf(
                "/v1/showcase/fs/%s/update?shop_id=%s",
                $this->getCredential()->getFsId(),
                $shopId
            ),
            Arr::only($payload, ["id", "name"])
        );

        return $this->handleResponse($response);
    }

    /**
     * @param $shopId
     * @param array $payload
     * @return string
     */
    public function deleteShowcaseByShopId($shopId, array $payload)
    {
        $response = $this->http()->post(
            sprintf(
                "/v1/showcase/fs/%s/delete?shop_id=%s",
                $this->getCredential()->getFsId(),
                $shopId
            ),
            Arr::only($payload, ["id"])
        );

        return $this->handleResponse($response);
    }
}
