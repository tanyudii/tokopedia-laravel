<?php

namespace tanyudii\Laratok\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static object registerPublicKey(bool $forceGenerate = false)
 * @method static bool verify()
 * @method static array decodeData(string $secret, string $content)
 *
 * @see \tanyudii\Laratok\Services\Tokopedia\Encryption
 */
class EncryptionService extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return "laratok-encryption-service";
    }
}
