<?php
declare(strict_types=1);
namespace Anura;

use Anura\AdditionalData;

/**
 * An object that represents an Anura Direct API request.
 */
class DirectRequest
{
    private ?string $source;
    private ?string $campaign;
    private string $ipAddress;
    private ?string $userAgent;
    private ?string $app;
    private ?string $device;
    private ?AdditionalData $additionalData;
    
    public function __construct(
        string $source,
        string $campaign,
        string $ipAddress,
        string $userAgent,
        string $app,
        string $device,
        AdditionalData $additionalData
    )
    {
        $this->source = $source;
        $this->campaign = $campaign;
        $this->ipAddress = $ipAddress ?? "";
        $this->userAgent = $userAgent;
        $this->app = $app;
        $this->device = $device;
        $this->additionalData = $additionalData;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): void
    {
        $this->source = $source;
    }

    public function getCampaign(): ?string
    {
        return $this->campaign;
    }

    public function setCampaign(string $campaign): void
    {
        $this->campaign = $campaign;
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(string $ipAddress): void
    {
        $this->ipAddress = $ipAddress;
    }

    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    public function setUserAgent(string $userAgent): void
    {
        $this->userAgent = $userAgent;
    }

    public function getApp(): string
    {
        return $this->app;
    }

    public function setApp(string $app): void
    {
        $this->app = $app;
    }

    public function getDevice(): string
    {
        return $this->device;
    }

    public function setDevice(string $device): void
    {
        $this->device = $device;
    }

    public function getAdditionalData(): ?AdditionalData
    {
        return $this->additionalData;
    }

    public function setAdditionalData(AdditionalData $additionalData): void
    {
        $this->additionalData = $additionalData;
    }
}