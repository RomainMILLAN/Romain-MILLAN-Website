<?php

namespace App\Infrastructure\Twig\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AlertExtension extends AbstractExtension
{
    private const array ICONS_BY_TYPES = [
        'info' => 'tabler:info-circle',
        'success' => 'tabler:check',
        'warning' => 'tabler:alert-triangle-filled',
        'danger' => 'tabler:alert-circle-filled',
    ];

    public function getFunctions(): array
    {
        return [
            new TwigFunction('alert_icon', fn (string $value) => $this->getAlertIconByType($value)),
        ];
    }

    private function getAlertIconByType(string $type = 'info'): string
    {
        return self::ICONS_BY_TYPES[$type] ?? 'tabler:info-circle';
    }
}
