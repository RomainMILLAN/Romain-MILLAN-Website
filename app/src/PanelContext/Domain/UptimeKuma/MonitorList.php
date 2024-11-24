<?php

namespace App\PanelContext\Domain\UptimeKuma;

class MonitorList
{
    private array $monitors = [];

    public function __construct(array $monitors)
    {
        $this->monitors = array_filter($monitors, fn ($monitor) => $monitor->getType() !== 'group');
    }

    public function isAnyMonitorDown(): bool
    {
        foreach ($this->monitors as $monitor) {
            if ($monitor->getStatus()->value === MonitorStatus::DOWN) {
                return true;
            }
        }

        return false;
    }

    public function countByStatus(string $status): int
    {
        return count(array_filter($this->monitors, fn ($monitor) => $monitor->getStatus()->value === $status));
    }

    public function percentOfStatus(string $status): float
    {
        $total = count($this->monitors);
        if ($total === 0) {
            return 0.0;
        }

        $count = $this->countByStatus($status);

        return ($count / $total) * 100;
    }

    public function averageResponseTime(): float
    {
        $totalResponseTime = 0.0;
        $count = 0;

        /** @var Monitor $monitor */
        foreach ($this->monitors as $monitor) {
            $responseTime = $monitor->getResponseTime();
            if ($responseTime >= 0) {
                $totalResponseTime += $responseTime;
                ++$count;
            }
        }

        return $count > 0 ? $totalResponseTime / $count : 0.0;
    }
}
