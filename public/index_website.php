<?php

use App\Kernel;
use Sulu\Component\HttpKernel\SuluKernel;

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG'], SuluKernel::CONTEXT_WEBSITE);
};
