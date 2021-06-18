<?php

namespace tanyudii\Laratok\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use tanyudii\Laratok\Contracts\CredentialContract;
use tanyudii\Laratok\Exceptions\LaratokException;

final class Credential implements CredentialContract
{
    /**
     * @var string
     */
    protected $clientId;

    /**
     * @var string
     */
    protected $clientSecret;

    /**
     * @var string
     */
    protected $fsId;

    /**
     * @var boolean
     */
    protected $cached;

    public function __construct()
    {
        $this->setClientId(Config::get("laratok.client_id"));
        $this->setClientSecret(Config::get("laratok.client_secret"));
        $this->setFsId(Config::get("laratok.fs_id"));
        $this->setCached(Config::get("laratok.cached", false));
    }

    /**
     * @return array
     * @throws LaratokException
     */
    protected function getAuthentication()
    {
        if (!$this->getCached()) {
            return $this->getCredentialFromServer();
        }

        $currentCredential = $this->getCredentialFromCache();
        if (empty($currentCredential)) {
            $currentCredential = $this->getCredentialFromServer();
            $this->putToCache($currentCredential);
        }

        return $currentCredential;
    }

    /**
     * @param array $credential
     * @return bool
     * @throws LaratokException
     */
    protected function putToCache(array $credential)
    {
        $credential = $this->checkCredentialData($credential);

        Cache::put(
            $this->getCacheTag(),
            json_encode($credential),
            $credential["expires_in"]
        );

        return true;
    }

    /**
     * @return array|null
     * @throws LaratokException
     */
    protected function getCredentialFromCache()
    {
        $credentialFromCache = Cache::get($this->getCacheTag());
        if (empty($credentialFromCache)) {
            return null;
        }

        return $this->checkCredentialData(
            (array) json_decode($credentialFromCache)
        );
    }

    /**
     * @return array
     * @throws LaratokException
     */
    protected function getCredentialFromServer()
    {
        $response = Http::withHeaders([
            "Authorization" => sprintf("Basic %s", $this->getSerializeClient()),
            "User-Agent" => "insomnia/2020.3.3",
        ])->post(
            "https://accounts.tokopedia.com/token?grant_type=client_credentials"
        );

        if ($response->json("access_denied")) {
            throw new LaratokException(
                sprintf(
                    "The client id or client secret is invalid. Response: %s",
                    $response->json("error_description")
                )
            );
        }

        return $this->checkCredentialData((array) $response->object());
    }

    /**
     * @param array $payload
     * @return array
     * @throws LaratokException
     */
    protected function checkCredentialData(array $payload)
    {
        $requiredAttributes = [
            "access_token",
            "expires_in",
            "event_code",
            "last_login_type",
            "sq_check",
            "token_type",
        ];

        foreach ($requiredAttributes as $requiredAttribute) {
            if (!isset($payload[$requiredAttribute])) {
                throw new LaratokException(
                    sprintf(
                        "Malformed Credential, The attribute %s is not present.",
                        $requiredAttribute
                    )
                );
            }
        }

        return $payload;
    }

    /**
     * @return string
     */
    protected function getCacheTag()
    {
        return $this->getSerializeClient();
    }

    /**
     * @return string
     */
    protected function getSerializeClient(): string
    {
        return base64_encode(
            sprintf("%s:%s", $this->getClientId(), $this->getClientSecret())
        );
    }

    /**
     * @return string
     * @throws LaratokException
     */
    public function getBearerToken(): string
    {
        $accessToken = $this->getAuthentication()["access_token"];
        return "Bearer $accessToken";
    }

    /**
     * @inheritdoc
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @inheritdoc
     */
    public function setClientId(string $clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * @inheritdoc
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @inheritdoc
     */
    public function setClientSecret(string $clientSecret): void
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * @inheritdoc
     */
    public function getFsId(): string
    {
        return $this->fsId;
    }

    /**
     * @inheritdoc
     */
    public function setFsId(string $fsId): void
    {
        $this->fsId = $fsId;
    }

    /**
     * @inheritdoc
     */
    public function getCached(): bool
    {
        return $this->cached;
    }

    /**
     * @inheritdoc
     */
    public function setCached(bool $cached): void
    {
        $this->cached = $cached;
    }
}
