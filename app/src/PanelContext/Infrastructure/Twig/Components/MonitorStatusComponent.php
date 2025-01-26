<?php

namespace Panel\Infrastructure\Twig\Components;

use Panel\Domain\UptimeKuma\MonitorList;
use Panel\Domain\UptimeKuma\MonitorStatus;
use Panel\Infrastructure\UptimeKuma\UptimeKumaClient;
use Panel\Infrastructure\UptimeKuma\UptimeKumaResponseParser;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent(
    name: 'MonitorStatus',
    template: 'components/panel/monitorStatus.html.twig'
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
        $this->monitorList = new MonitorList([]);
    }

    public function fetchData(): MonitorList
    {
        $uptimeResponse = $this->uptimeKumaClient->request('metrics');
        if ($uptimeResponse !== null) {
            $this->monitorList = new MonitorList($this->uptimeKumaResponseParser->parseMonitors(
                $uptimeResponse->getContent()
            ));
        }

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
