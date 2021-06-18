<?php

namespace tanyudii\Laratok\Contracts;

interface CredentialContract
{
    /**
     * @return string
     */
    public function getBearerToken(): string;

    /**
     * @return string
     */
    public function getClientId(): string;

    /**
     * @param string $clientId
     * @return void
     */
    public function setClientId(string $clientId): void;

    /**
     * @return string
     */
    public function getClientSecret(): string;

    /**
     * @param string $clientSecret
     * @return void
     */
    public function setClientSecret(string $clientSecret): void;

    /**
     * @return string
     */
    public function getFsId(): string;

    /**
     * @param string $fsId
     * @return void
     */
    public function setFsId(string $fsId): void;

    /**
     * @return bool
     */
    public function getCached(): bool;

    /**
     * @param bool $cached
     * @return void
     */
    public function setCached(bool $cached): void;
}
