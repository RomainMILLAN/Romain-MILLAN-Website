<?php

namespace App\PanelContext\Infrastructure\Twig\Components;

use App\PanelContext\Domain\UptimeKuma\MonitorList;
use App\PanelContext\Domain\UptimeKuma\MonitorStatus;
use App\PanelContext\Infrastructure\UptimeKuma\UptimeKumaClient;
use App\PanelContext\Infrastructure\UptimeKuma\UptimeKumaResponseParser;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent(
    name: 'MonitorStatus',
    template: 'components/MonitorStatus.html.twig'
)]
class MonitorStatusComponent
{
    use DefaultActionTrait;

    #[LiveProp]
    public ?string $monitorStatus = null;

    private MonitorList $monitorList;

    public function __construct(
        private readonly UptimeKumaClient $uptimeKumaClient,
        private readonly UptimeKumaResponseParser $uptimeKumaResponseParser,
    ) {
    }

    public function fetchData(): MonitorList
    {
        $this->monitorList = new MonitorList($this->uptimeKumaResponseParser->parseMonitors(
            $this->uptimeKumaClient->request('metrics')->getContent()
        ));

        return $this->monitorList;
    }

    public function getColor(float $percent): string
    {
        if ($this->monitorStatus === MonitorStatus::DOWN->value && $percent > 0) {
            return 'red';
        }

        if ($this->monitorStatus === MonitorStatus::UP->value) {
            if ($this->monitorList->percentOfStatus(MonitorStatus::DOWN->value) > 0) {
                return 'red';
            }

            if ($this->monitorList->percentOfStatus(MonitorStatus::UP->value) < 100) {
                return 'orange';
            }
        }

        return 'green';
    }
}
