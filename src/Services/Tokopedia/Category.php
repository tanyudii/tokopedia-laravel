<?php

namespace tanyudii\Laratok\Services\Tokopedia;

use Illuminate\Support\Arr;
use tanyudii\Laratok\Services\AbstractService;

class Category extends AbstractService
{
    /**
     * @param array $payload
     * @return string
     */
    public function getAllCategories(array $payload = [])
    {
        $response = $this->http()->get(
            sprintf(
                "/inventory/v1/fs/%s/product/category?%s",
                $this->getCredential()->getFsId(),
                http_build_query(Arr::only($payload, ["keyword"]))
            )
        );

        return $this->handleResponse($response);
    }
}
