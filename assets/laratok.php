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
];
