<?php

namespace Panel\Domain\UptimeKuma;

class Monitor
{
    private MonitorStatus $status;

    private float $responseTime;

    private CertValidationStatus $certValidationStatus;

    private int $certExpiryDays;

    public function __construct(
        private readonly string $name,
        private readonly ?string $type = null,
        private readonly ?string $url = null,
        private readonly ?string $hostname = null,
        private readonly ?string $port = null,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getHostname(): ?string
    {
        return $this->hostname;
    }

    public function getPort(): ?string
    {
        return $this->port;
    }

    public function getStatus(): MonitorStatus
    {
        return $this->status;
    }

    public function setStatus(MonitorStatus $status): void
    {
        $this->status = $status;
    }

    public function getResponseTime(): float
    {
        return $this->responseTime;
    }

    public function setResponseTime(float $responseTime): void
    {
        $this->responseTime = $responseTime;
    }

    public function getCertValidationStatus(): CertValidationStatus
    {
        return $this->certValidationStatus;
    }

    public function setCertValidationStatus(CertValidationStatus $certValidationStatus): void
    {
        $this->certValidationStatus = $certValidationStatus;
    }

    public function getCertExpiryDays(): int
    {
        return $this->certExpiryDays;
    }

    public function setCertExpiryDays(int $certExpiryDays): void
    {
        $this->certExpiryDays = $certExpiryDays;
    }
}
