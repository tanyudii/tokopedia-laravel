<?php

namespace tanyudii\Laratok\Services\Tokopedia;

use Illuminate\Support\Arr;
use tanyudii\Laratok\Services\AbstractService;

class Product extends AbstractService
{
    /**
     * @param array $payload
     * @return string
     */
    public function getProductInfoByProductIdOrUrl(array $payload = [])
    {
        $response = $this->http()->get(
            sprintf(
                "/inventory/v1/fs/%s/product/info?%s",
                $this->getCredential()->getFsId(),
                http_build_query(
                    Arr::only($payload, ["product_id", "product_url"])
                )
            )
        );

        return $response->object() ?: $response->body();
    }

    /**
     * @param $shopId
     * @param $page
     * @param $perPage
     * @param array $payload
     * @return string
     */
    public function getProductInfoFromRelatedShopId(
        $shopId,
        $page,
        $perPage,
        array $payload = []
    ) {
        $response = $this->http()->get(
            sprintf(
                "/inventory/v1/fs/%s/product/info?shop_id=%s&page=%s&per_page=%s&%s",
                $this->getCredential()->getFsId(),
                $shopId,
                $page,
                $perPage,
                http_build_query(Arr::only($payload, ["sort"]))
            )
        );

        return $response->object() ?: $response->body();
    }

    /**
     * @param $page
     * @param $perPage
     * @param array $payload
     * @return string
     */
    public function getAllProductsV2($page, $perPage, array $payload = [])
    {
        $response = $this->http()->get(
            sprintf(
                "/v2/products/fs/%s/%s/%s?%s",
                $this->getCredential()->getFsId(),
                $page,
                $perPage,
                http_build_query(Arr::only($payload, ["product_id"]))
            )
        );

        return $response->object() ?: $response->body();
    }

    /**
     * @param $shopId
     * @param $page
     * @param $perPage
     * @param array $payload
     * @return string
     */
    public function getAllActiveProducts(
        $shopId,
        $page,
        $perPage,
        array $payload = []
    ) {
        $response = $this->http()->get(
            sprintf(
                "/inventory/v1/fs/%s/product/list?shop_id=%s&rows=%s&start=%s&order_by=%s",
                $this->getCredential()->getFsId(),
                $shopId,
                $page,
                $page * $perPage,
                http_build_query(
                    Arr::only($payload, [
                        "order_by",
                        "keyword",
                        "exclude_keyword",
                        "sku",
                        "price_min",
                        "price_max",
                        "preorder",
                        "free_return",
                        "wholesale",
                    ])
                )
            )
        );

        return $response->object() ?: $response->body();
    }

    /**
     * @param $categoryId
     * @return string
     */
    public function getAllVariantsByCategory($categoryId)
    {
        $response = $this->http()->get(
            sprintf(
                "/inventory/v1/fs/%s/category/get_variant?cat_id=%s",
                $this->getCredential()->getFsId(),
                $categoryId
            )
        );

        return $response->object() ?: $response->body();
    }

    /**
     * @param $productId
     * @return string
     */
    public function getAllVariantsByProduct($productId)
    {
        $response = $this->http()->get(
            sprintf(
                "/inventory/v1/fs/%s/product/variant/%s",
                $this->getCredential()->getFsId(),
                $productId
            )
        );

        return $response->object() ?: $response->body();
    }

    /**
     * @param $shopId
     * @param array $payload
     * @return string
     */
    public function createProductsV2($shopId, array $payload)
    {
        $response = $this->http()->post(
            sprintf(
                "/v2/products/fs/%s/create?shop_id=%s",
                $this->getCredential()->getFsId(),
                $shopId
            ),
            Arr::only($payload, ["products"])
        );

        return $response->object() ?: $response->body();
    }

    /**
     * @param $shopId
     * @param array $payload
     * @return string
     */
    public function createProductsV3($shopId, array $payload)
    {
        $response = $this->http()->post(
            sprintf(
                "/v3/products/fs/%s/create?shop_id=%s",
                $this->getCredential()->getFsId(),
                $shopId
            ),
            Arr::only($payload, ["products"])
        );

        return $response->object() ?: $response->body();
    }

    /**
     * @param $shopId
     * @param array $payload
     * @return string
     */
    public function updateProductV2($shopId, array $payload)
    {
        $response = $this->http()->patch(
            sprintf(
                "/v2/products/fs/%s/edit?shop_id=%s",
                $this->getCredential()->getFsId(),
                $shopId
            ),
            Arr::only($payload, ["products"])
        );

        return $response->object() ?: $response->body();
    }

    /**
     * @param $shopId
     * @param array $payload
     * @return string
     */
    public function updateProductV3($shopId, array $payload)
    {
        $response = $this->http()->patch(
            sprintf(
                "/v3/products/fs/%s/edit?shop_id=%s",
                $this->getCredential()->getFsId(),
                $shopId
            ),
            Arr::only($payload, ["products"])
        );

        return $response->object() ?: $response->body();
    }

    /**
     * @param $shopId
     * @param array $payload
     * @return string
     */
    public function deleteProductV3($shopId, array $payload)
    {
        $response = $this->http()->post(
            sprintf(
                "/v3/products/fs/%s/delete?shop_id=%s",
                $this->getCredential()->getFsId(),
                $shopId
            ),
            $payload
        );

        return $response->object() ?: $response->body();
    }

    /**
     * @param $shopId
     * @param array $payload
     * @return string
     */
    public function setActiveProduct($shopId, array $payload)
    {
        $response = $this->http()->post(
            sprintf(
                "/v1/products/fs/%s/active?shop_id=%s",
                $this->getCredential()->getFsId(),
                $shopId
            ),
            Arr::only($payload, ["product_id"])
        );

        return $response->object() ?: $response->body();
    }

    /**
     * @param $shopId
     * @param array $payload
     * @return string
     */
    public function setInactiveProduct($shopId, array $payload)
    {
        $response = $this->http()->post(
            sprintf(
                "/v1/products/fs/%s/inactive?shop_id=%s",
                $this->getCredential()->getFsId(),
                $shopId
            ),
            Arr::only($payload, ["product_id"])
        );

        return $response->object() ?: $response->body();
    }

    /**
     * @param $shopId
     * @param array $payload
     * @return string
     */
    public function updatePriceOnly($shopId, array $payload)
    {
        $response = $this->http()->post(
            sprintf(
                "/inventory/v1/fs/%s/price/update?shop_id=%s",
                $this->getCredential()->getFsId(),
                $shopId
            ),
            $payload
        );

        return $response->object() ?: $response->body();
    }

    /**
     * @param $shopId
     * @param array $payload
     * @return string
     */
    public function updateStockByOverwrite($shopId, array $payload)
    {
        $response = $this->http()->post(
            sprintf(
                "/inventory/v1/fs/%s/stock/update?shop_id=%s",
                $this->getCredential()->getFsId(),
                $shopId
            ),
            $payload
        );

        return $response->object() ?: $response->body();
    }

    /**
     * @param $shopId
     * @param array $payload
     * @return string
     */
    public function updateStockByIncrement($shopId, array $payload)
    {
        $response = $this->http()->post(
            sprintf(
                "/inventory/v2/fs/%s/stock/increment?shop_id=%s",
                $this->getCredential()->getFsId(),
                $shopId
            ),
            $payload
        );

        return $response->object() ?: $response->body();
    }

    /**
     * @param $shopId
     * @param array $payload
     * @return string
     */
    public function updateStockByDecrement($shopId, array $payload)
    {
        $response = $this->http()->post(
            sprintf(
                "/inventory/v2/fs/%s/stock/decrement?shop_id=%s",
                $this->getCredential()->getFsId(),
                $shopId
            ),
            $payload
        );

        return $response->object() ?: $response->body();
    }
}
