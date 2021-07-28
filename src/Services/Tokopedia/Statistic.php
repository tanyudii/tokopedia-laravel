<?php

namespace tanyudii\Laratok\Services\Tokopedia;

use Illuminate\Support\Arr;
use tanyudii\Laratok\Services\AbstractService;

class Statistic extends AbstractService
{
    /**
     * @return object|string
     */
    public function getShopPerformance($shopId, $startDate, $endDate)
    {
        $response = $this->http()->get(
            sprintf("/v1/statistic/shop-performance/fs/%s/%s?start_date=%s&end_date=%s",
                $this->getCredential()->getFsId(),
                $shopId,
                $startDate,
                $endDate
            )
        );

        return $this->handleResponse($response);
    }

    /**
     * @return object|string
     */
    public function getProductStatistics($shopId, $startDate, $endDate, $pageSize)
    {
        $response = $this->http()->get(
            sprintf("/v1/statistic/product-statistics/fs/%s/%s?start_date=%s&end_date=%s&pagesize=%s",
                $this->getCredential()->getFsId(),
                $shopId,
                $startDate,
                $endDate,
                $pageSize
            )
        );

        return $this->handleResponse($response);
    }

    /**
     * @return object|string
     */
    public function getTransactionStatistics($shopId, $startDate, $endDate, array $payload)
    {
        $response = $this->http()->get(
            sprintf("/v1/statistic/transaction-statistics/fs/%s/%s?start_date=%s&end_date=%s&%s",
                $this->getCredential()->getFsId(),
                $shopId,
                $startDate,
                $endDate,
                http_build_query(
                    Arr::only($payload, ["page_size"])
                )
            )
        );

        return $this->handleResponse($response);
    }

    /**
     * @return object|string
     */
    public function getBuyerStatistics($shopId, $startDate, $endDate, $payload)
    {
        $response = $this->http()->get(
            sprintf("/v1/statistic/buyer-statistics/fs/%s/%s?start_date=%s&end_date=%s&page_size=%s",
                $this->getCredential()->getFsId(),
                $shopId,
                $startDate,
                $endDate,
                http_build_query(
                    Arr::only($payload, ["page_size", "sort_by", "sort_type"])
                )
            )
        );

        return $this->handleResponse($response);
    }
}
