<?php

namespace tanyudii\Laratok\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static object getAllCategories(array $payload = [])
 *
 * @see \tanyudii\Laratok\Services\LaratokService
 */
class CategoryService extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return "laratok-category-service";
    }
}
