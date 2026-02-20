<?php

declare(strict_types=1);

namespace App;

use FOS\HttpCache\SymfonyCache\HttpCacheProvider;
use Sulu\Bundle\HttpCacheBundle\Cache\SuluHttpCache;
use Sulu\Component\HttpKernel\SuluKernel;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class Kernel extends SuluKernel implements HttpCacheProvider
{
    private ?HttpKernelInterface $httpCache = null;

    public function getHttpCache(): HttpKernelInterface
    {
        if (!$this->httpCache instanceof HttpKernelInterface) {
            $this->httpCache = new SuluHttpCache($this);
        }

        return $this->httpCache;
    }
}
