<?php

namespace tanyudii\Laratok\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use tanyudii\Laratok\Contracts\AbstractServiceContract;
use tanyudii\Laratok\Contracts\CredentialContract;

abstract class AbstractService implements AbstractServiceContract
{
    /**
     * @var CredentialContract
     */
    protected $credential;

    /**
     * @var string
     */
    protected $baseUrl = "https://fs.tokopedia.net";

    /**
     * @var array
     */
    protected $headers = [];

    public function __construct()
    {
        $this->setCredential(new Credential());
        $this->setHeaders([
            "Authorization" => $this->getCredential()->getBearerToken(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getCredential(): CredentialContract
    {
        return $this->credential;
    }

    /**
     * @inheritdoc
     */
    public function setCredential(CredentialContract $credential): void
    {
        $this->credential = $credential;
    }

    /**
     * @inheritdoc
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @inheritdoc
     */
    public function setBaseUrl(string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @inheritdoc
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @inheritdoc
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * @inheritdoc
     */
    public function http()
    {
        return Http::withHeaders($this->getHeaders())->baseUrl(
            $this->getBaseUrl()
        );
    }

    /**
     * @inheritdoc
     */
    public function handleResponse(Response $response)
    {
        return $response->object() ?:
            trim(preg_replace("/\s\s+/", " ", $response->body()));
    }
}
