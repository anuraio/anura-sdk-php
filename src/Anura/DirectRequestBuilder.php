<?php
declare(strict_types=1);
namespace Anura;

use Anura\DirectRequest;
use Anura\AdditionalData;

/**
 * Builder class for creating a DirectRequest.
 */
class DirectRequestBuilder
{
    private ?string $source;
    private ?string $campaign;
    private string $ipAddress;
    private ?string $userAgent;
    private ?string $app;
    private ?string $device;
    private ?AdditionalData $additionalData;
    
    public function __construct()
    {
        $this->source = "";
        $this->campaign = "";
        $this->ipAddress = "";
        $this->userAgent = "";
        $this->app = "";
        $this->device = "";
        $this->additionalData = new AdditionalData();
    }

    /**
     * Builds and returns a DirectRequest.
     */
    public function build(): DirectRequest
    {
        return new DirectRequest(
            $this->source,
            $this->campaign,
            $this->ipAddress,
            $this->userAgent,
            $this->app,
            $this->device,
            $this->additionalData
        );
    }

    /**
     * Sets this DirectRequest's source. 
     * A source is a variable, declared by you, to identify "source" traffic within Anura Dashboard's interface.
     */
    public function setSource(string $source): DirectRequestBuilder
    {
        $this->source = $source;
        return $this;
    }

    /**
     * Sets this DirectRequest's campaign. 
     * A campaign is a subset variable of "source", declared by you, to identify "campaign" traffic within Anura Dashboard's interface.
     */
    public function setCampaign(string $campaign): DirectRequestBuilder
    {
        $this->campaign = $campaign;
        return $this;
    }

    /**
     * Sets this DirectRequest's IP Address. Necessary for all requests used by AnuraDirect. 
     * Both IPv4 and IPv6 addresses are supported.
     */
    public function setIpAddress(string $ipAddress): DirectRequestBuilder
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    /**
     * Sets this DirectRequest's user agent. 
     * Providing a user agent increases the accuracy of results.
     */
    public function setUserAgent(string $userAgent): DirectRequestBuilder
    {
        $this->userAgent = $userAgent;
        return $this;
    }

    /**
     * Sets this DirectRequest's application package identifier. 
     * While not required, it's highly encouraged to supply an application package identifier when available, 
     * as it will allow Anura Direct to assess a visitor more accurately. 
     * This ID may also be referred as app ID, bundle ID, package name, etc.
     */
    public function setApp(string $app): DirectRequestBuilder
    {
        $this->app = $app;
        return $this;
    }

    /**
     * Sets this DirectRequest's device identifer. 
     * While not required, it's highly encouraged to supply a device identifier when available.
     */
    public function setDevice(string $device): DirectRequestBuilder
    {
        $this->device = $device;
        return $this;
    }

    /**
     * Sets this DirectRequest's additional data. 
     */
    public function setAdditionalData(AdditionalData $additionalData): DirectRequestBuilder
    {
        $this->additionalData = $additionalData;
        return $this;
    }
}