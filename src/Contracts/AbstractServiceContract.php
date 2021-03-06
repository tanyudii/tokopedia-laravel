<?php

namespace tanyudii\Laratok\Contracts;

use Illuminate\Http\Client\Response;

interface AbstractServiceContract
{
    /**
     * @return CredentialContract
     */
    public function getCredential(): CredentialContract;

    /**
     * @param CredentialContract $credential
     */
    public function setCredential(CredentialContract $credential): void;

    /**
     * @return string
     */
    public function getBaseUrl(): string;

    /**
     * @param string $baseUrl
     * @return void
     */
    public function setBaseUrl(string $baseUrl): void;

    /**
     * @return array
     */
    public function getHeaders(): array;

    /**
     * @param array $headers
     * @return void
     */
    public function setHeaders(array $headers): void;

    /**
     * @return mixed
     */
    public function http();

    /**
     * @param Response $response
     * @return mixed
     */
    public function handleResponse(Response $response);
}
