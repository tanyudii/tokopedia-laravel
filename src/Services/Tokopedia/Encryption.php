<?php

namespace tanyudii\Laratok\Services\Tokopedia;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use tanyudii\Laratok\Services\AbstractService;
use function base_path;

class Encryption extends AbstractService
{
    /**
     * @param bool $forceGenerate
     * @return string
     * @throws Exception
     */
    public function registerPublicKey(bool $forceGenerate = false)
    {
        $this->generate($forceGenerate);

        $response = Http::withHeaders($this->getHeaders())
            ->baseUrl($this->getBaseUrl())
            ->attach("public_key", fopen($this->getPublicKeyPath(), "r"))
            ->post(
                sprintf(
                    "/v1/fs/%s/register?upload=1",
                    $this->getCredential()->getFsId()
                )
            );

        return $this->handleResponse($response);
    }

    /**
     * @param string $secret
     * @param string $content
     * @return array
     * @throws Exception
     */
    public function decodeData(string $secret, string $content)
    {
        try {
            if (empty($secret) || empty($content)) {
                return [];
            }

            $privateKeyPath = $this->getPrivateKeyPath();
            $decryptSecretShellFile = $this->getShellPath("decrypt-secret.sh");

            $secret = shell_exec(
                implode(" ", [
                    $decryptSecretShellFile,
                    $privateKeyPath,
                    $secret,
                ])
            );

            $bContent = base64_decode($content);
            $bnonce = substr(
                $bContent,
                strlen($bContent) - 12,
                strlen($bContent)
            );
            $bcipher = substr($bContent, 0, strlen($bContent) - 12);

            $tagLength = 16;
            $tag = substr(
                $bcipher,
                strlen($bcipher) - $tagLength,
                strlen($bcipher)
            );

            $acipher = substr($bcipher, 0, strlen($bcipher) - $tagLength);

            $resultJson = openssl_decrypt(
                $acipher,
                "aes-256-gcm",
                $secret,
                OPENSSL_RAW_DATA,
                $bnonce,
                $tag
            );

            return (array) json_decode($resultJson, true);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function verify()
    {
        try {
            $content = '{"fs_id":13000}';

            $privateKeyPath = $this->getPrivateKeyPath();
            $publicKeyPath = $this->getPublicKeyPath();

            $signed = shell_exec(
                "echo -n '$content' | openssl dgst -sign $privateKeyPath -sigopt rsa_padding_mode:pss -sha256 | openssl base64 -A"
            );

            $signShellFile = $this->getShellPath("sign.sh");
            $verifyShellFile = $this->getShellPath("verify.sh");

            $tokopediaSignature = shell_exec(
                implode(" ", [$signShellFile, $signed, $privateKeyPath])
            );

            $exploded = explode("TKPD-Signature:", $tokopediaSignature);
            $signature = end($exploded);

            $result = shell_exec(
                implode(" ", [
                    $verifyShellFile,
                    $signed,
                    $publicKeyPath,
                    $signature,
                ])
            );

            $result = trim(preg_replace("/\s\s+/", " ", $result));

            return $result == "Verified OK";
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @param string $fileName
     * @return string
     */
    protected function getShellPath(string $fileName)
    {
        return base_path(
            "vendor/tanyudii/laratok/src/TokopediaSdk/" . $fileName
        );
    }

    /**
     * @param string $fileName
     * @return string
     */
    protected function getFilePath(string $fileName)
    {
        return base_path() .
            Storage::disk(Config::get("laratok.encryption.key_storage"))->url(
                $fileName
            );
    }

    /**
     * @return string
     */
    protected function getPrivateKeyPath()
    {
        return $this->getFilePath(
            Config::get("laratok.encryption.private_key_name")
        );
    }

    /**
     * @return string
     */
    protected function getPublicKeyPath()
    {
        return $this->getFilePath(
            Config::get("laratok.encryption.public_key_name")
        );
    }

    /**
     * @param bool $forceGenerate
     * @return void|false|string|null
     */
    protected function generate(bool $forceGenerate = false)
    {
        $privateKeyPath = $this->getPrivateKeyPath();
        $publicKeyPath = $this->getPublicKeyPath();

        if (
            !$forceGenerate &&
            file_exists($privateKeyPath) &&
            file_exists($publicKeyPath)
        ) {
            return;
        }

        $generateShellFile = $this->getShellPath("generate.sh");

        try {
            return shell_exec(
                implode(" ", [
                    $generateShellFile,
                    $publicKeyPath,
                    $privateKeyPath,
                ])
            );
        } catch (Exception $e) {
            throw $e;
        }
    }
}
