<?php

namespace tanyudii\Laratok\Services;

use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use tanyudii\Laratok\Contracts\AbstractServiceContract;
use tanyudii\Laratok\Contracts\CredentialContract;
use tanyudii\Laratok\Events\LaratokServiceCalled;

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

    /**
     * @var Dispatcher
     */
    protected $events;

    public function __construct(Dispatcher $events)
    {
        $this->setCredential(new Credential());
        $this->setHeaders([
            "Authorization" => $this->getCredential()->getBearerToken(),
        ]);
        $this->events = $events;
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
        $transferStats = $response->transferStats;
        $request = $transferStats->getRequest();
        $url = $transferStats->getHandlerStat('url');
        $httpMethod = $request->getMethod();
        $body = $request->getBody();
        $body->rewind();
        $requestBody = $body->getContents();

        $responseData = $response->object() ?: trim(preg_replace("/\s\s+/", " ", $response->body()));
        if (is_array($responseData) || is_object($responseData)) {
            $responseData = json_encode((array) $responseData);
        }

        $this->events->dispatch(new LaratokServiceCalled($url, $httpMethod, $requestBody, $responseData));

        return $response->object() ?:
            trim(preg_replace("/\s\s+/", " ", $response->body()));
    }
}
