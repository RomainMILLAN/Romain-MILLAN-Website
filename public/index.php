<?php

use App\Kernel;
use Sulu\Component\HttpKernel\SuluKernel;

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

return function (array $context) {
    $uri = explode('?', $_SERVER['REQUEST_URI'] ?? '/')[0];

    // Website context only for locale-prefixed URLs (Sulu pages)
    // Admin context for /admin and all other routes (/, /panel, /security, etc.)
    $suluContext = SuluKernel::CONTEXT_ADMIN;

    if (preg_match('#^/(fr|en)(/|$)#', $uri) || preg_match('#^/(media|uploads/media)/#', $uri)) {
        $suluContext = SuluKernel::CONTEXT_WEBSITE;
    }

    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG'], $suluContext);
};
