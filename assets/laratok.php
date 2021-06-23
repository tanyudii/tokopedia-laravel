<?php

return [
    /**
     * Tokopedia Client ID
     */
    "client_id" => env("LARATOK_CLIENT_ID"),

    /**
     * Tokopedia Client Secret
     */
    "client_secret" => env("LARATOK_CLIENT_SECRET"),

    /**
     * Tokopedia Fs ID
     */
    "fs_id" => env("LARATOK_FS_ID"),

    /**
     * Tokopedia Fs ID
     */
    "cached" => (bool) env("LARATOK_CACHED", false),

    /**
     * The encryption configuration
     */
    "encryption" => [
        /**
         * The storage for save encryption key
         */
        "key_storage" => env(
            "LARATOK_KEY_STORAGE",
            config("filesystems.default")
        ),

        /**
         * The file name of private key
         */
        "private_key_name" => env(
            "LARATOK_PRIVATE_KEY_NAME",
            "private_key.pem"
        ),

        /**
         * The file name of public key
         */
        "public_key_name" => env("LARATOK_PUBLIC_KEY_NAME", "public_key.pub"),

        /**
         * The file name of open api public key from tokopedia
         */
        "open_api_key_name" => env(
            "LARATOK_OPEN_API_KEY_NAME",
            "openapi-pub.txt"
        ),
    ],
];
