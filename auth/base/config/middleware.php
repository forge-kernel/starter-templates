<?php

return [
    "global" => [
        \Modules\ForgeRouter\Http\Middlewares\CorsMiddleware::class,
        \Modules\ForgeRouter\Http\Middlewares\SanitizeInputMiddleware::class,
        \Modules\ForgeRouter\Http\Middlewares\CompressionMiddleware::class,
    ],
    "web" => [
        \Modules\ForgeRouter\Http\Middlewares\SessionMiddleware::class,
        \Modules\ForgeRouter\Http\Middlewares\CsrfMiddleware::class,
        \Modules\ForgeRouter\Http\Middlewares\RelaxSecurityHeadersMiddleware::class,
    ],
    "api" => [
        \Modules\ForgeRouter\Http\Middlewares\IpWhiteListMiddleware::class,
        \Modules\ForgeRouter\Http\Middlewares\ApiKeyMiddleware::class,
        \Modules\ForgeRouter\Http\Middlewares\CookieMiddleware::class,
    ],
];
