<?php

namespace App\PanelContext\Infrastructure\UptimeKuma;

use App\PanelContext\Domain\UptimeKuma\CertValidationStatus;
use App\PanelContext\Domain\UptimeKuma\Monitor;
use App\PanelContext\Domain\UptimeKuma\MonitorStatus;

class UptimeKumaResponseParser
{
    /**
     * @return array<mixed>
     */
    public function parseMonitors(string $content): array
    {
        $metricsData = $this->parseMetrics($content);
        $monitors = [];

        foreach ($metricsData as $metricName => $entries) {
            if (! is_array($entries)) {
                continue;
            }

            foreach ($entries as $entry) {
                [$labels, $value] = $entry;
                preg_match_all('/(\w+)="([^"]*)"/', $labels, $matches);
                $labelData = array_combine($matches[1], $matches[2]);


                $name = $labelData['monitor_name'] ?? null;
                if (! $name) {
                    continue;
                }

                if (! isset($monitors[$name])) {
                    $monitors[$name] = new Monitor(
                        $name,
                        $labelData['monitor_type'] ?? null,
                        $labelData['monitor_url'] ?? null,
                        $labelData['monitor_hostname'] ?? null,
                        $labelData['monitor_port'] ?? null
                    );
                }

                $monitor = $monitors[$name];
                switch ($metricName) {
                    case 'monitor_status':
                        $monitor->setStatus(MonitorStatus::fromAPIValue((int) $value));
                        break;
                    case 'monitor_response_time':
                        $monitor->setResponseTime((float) $value);
                        break;
                    case 'monitor_cert_is_valid':
                        $monitor->setCertValidationStatus(CertValidationStatus::fromAPIValue((int) $value));
                        break;
                    case 'monitor_cert_days_remaining':
                        $monitor->setCertExpiryDays((int) $value);
                        break;
                }
            }
        }

        return array_values($monitors);
    }

    /**
     * @return array<mixed>
     */
    private function parseMetrics(string $content): array
    {
        $lines = explode("\n", $content);

        $metricsArray = [];
        foreach ($lines as $line) {
            if (empty($line) || str_starts_with($line, '#')) {
                continue;
            }

            preg_match('/^(\w+)(\{.*?\})?\s+(.+)$/', $line, $matches);
            if ($matches) {
                $metricName = $matches[1];
                $labels = $matches[2] ?? null;
                $value = is_numeric($matches[3]) ? (float) $matches[3] : $matches[3];

                if ($labels) {
                    $metricsArray[$metricName][] = [$labels, $value];
                } else {
                    $metricsArray[$metricName] = $value;
                }
            }
        }

        return $metricsArray;
    }
}
