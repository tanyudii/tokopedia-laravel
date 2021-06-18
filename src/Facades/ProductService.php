<?php

namespace tanyudii\Laratok\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static object getProductInfoByProductIdOrUrl(array $payload = [])
 * @method static object getProductInfoFromRelatedShopId($shopId, $page, $perPage, array $payload = [])
 * @method static object getAllProductsV2($page, $perPage, array $payload = [])
 * @method static object getAllActiveProducts($shopId, $page, $perPage, array $payload = [])
 * @method static object getAllVariantsByCategory($categoryId)
 * @method static object getAllVariantsByProduct($productId)
 * @method static object createProductsV2($shopId, array $payload)
 * @method static object createProductsV3($shopId, array $payload)
 * @method static object updateProductV2($shopId, array $payload)
 * @method static object updateProductV3($shopId, array $payload)
 * @method static object deleteProductV3($shopId, array $payload)
 * @method static object setActiveProduct($shopId, array $payload)
 * @method static object setInactiveProduct($shopId, array $payload)
 * @method static object updatePriceOnly($shopId, array $payload)
 * @method static object updateStockByOverwrite($shopId, array $payload)
 * @method static object updateStockByIncrement($shopId, array $payload)
 * @method static object updateStockByDecrement($shopId, array $payload)
 *
 * @see \tanyudii\Laratok\Services\Tokopedia\Product
 */
class ProductService extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return "laratok-product-service";
    }
}
