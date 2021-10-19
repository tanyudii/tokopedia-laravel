<?php

namespace tanyudii\Laratok\Events;

class LaratokServiceCalled
{
    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $httpMethod;

    /**
     * @var string
     */
    public $payload;

    /**
     * @var string
     */
    public $response;

    public function __construct(string $url, string $httpMethod, string $payload, string $response)
    {
        $this->url = $url;
        $this->httpMethod = $httpMethod;
        $this->payload = $payload;
        $this->response = $response;
    }
}
