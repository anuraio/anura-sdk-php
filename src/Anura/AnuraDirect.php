<?php
declare(strict_types=1);
namespace Anura;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Client;
use Exception;
use Anura\DirectResult;

class AnuraDirect
{
    private string $instance;
    private bool $useHttps;
    private ?string $lastReceivedError;
    private string $source = '';
    private string $campaign = '';
    private array $additionalData = [];
    private Client $client;

    public function __construct(string $instance, bool $useHttps = true)
    {
        $this->instance = $instance;
        $this->useHttps = $useHttps;
        $this->client = new Client();
    }

    /**
     * Gets a result from Anura Direct, or returns null if an error occurred. 
     * To retrieve the error that occurred, call the getError() method.
     */
    public function getResult(string $ipAddress, string $userAgent = '', string $app = '', string $device = ''): ?DirectResult
    {
        $params = [
            'instance' => $this->instance,
            'ip' => $ipAddress
        ];

        if ($userAgent) $params['ua'] = $userAgent;
        if ($this->source) $params['source'] = $this->source;
        if ($this->campaign) $params['campaign'] = $this->campaign;
        if ($app) $params['app'] = $app;
        if ($device) $params['device'] = $device;
        $additionalDataString = $this->getAdditionalDataString();
        if ($additionalDataString) {
            $params['additional'] = $additionalDataString;
        }

        $apiUrl = $this->getUrl() . '?' . http_build_query($params);

        $response = null;
        try {
            $response = $this->client->request('GET', $apiUrl);
        } catch (ClientException $e) {
            $body = json_decode($e->getResponse()->getBody()->getContents(), true);
            $error = $body['error'] ?? '';
            $this->lastReceivedError = $error;
            return null;
        } catch (ServerException $e) {
            $this->lastReceivedError = "Anura Server Error: " . $e->getResponse()->getStatusCode();
            return null;
        } catch (Exception $e) {
            $this->lastReceivedError = "Unknown error occurred";
            return null;
        }

        $result = json_decode($response->getBody()->getContents(), true);
        $directResult = new DirectResult($result['result'], $result['mobile'], $result['rule_sets'] ?? null, $result['invalid_traffic_type'] ?? null);

        return $directResult;
    }

    /**
     * Returns the last received error from Anura Direct. 
     * This method will return null if an error has not occurred.
     */
    public function getError(): ?string
    {
        return $this->lastReceivedError;
    }

    private function getUrl(): string
    {
        if ($this->useHttps) {
            return 'https://direct.anura.io/direct.json';
        } else {
            return 'http://direct.anura.io/direct.json';
        }
    }

    public function getInstance(): string
    {
        return $this->instance;
    }

    public function setInstance(string $instance): void
    {
        $this->instance = $instance;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function setSource(string $source): void
    {
        $this->source = $source;
    }

    public function getCampaign(): string
    {
        return $this->campaign;
    }

    public function setCampaign(string $campaign): void
    {
        $this->campaign = $campaign;
    }

    public function getAdditionalData(): array
    {
        return $this->additionalData;
    }

    /**
     * Adds a key/value pair to your additional data. 
     * If you call addAdditionalData() providing the same $key 
     * multiple times, the value of additionalData[$key] will 
     * be updated.
     */
    public function addAdditionalData(string $key, string $value): void
    {
        $this->additionalData[$key] = $value;
    }

    /**
     * Removes a key/value pair from Anura Direct's additional data.
     */
    public function removeAdditionalData(string $key): void
    {
        if ($this->additionalData[$key]) {
            unset($this->additionalData[$key]);
        }
    }

    /**
     * Converts an Additional Data associative array into a json-encoded 
     * string to be used when calling Direct. 
     */
    private function getAdditionalDataString(): string
    {
        if (count($this->additionalData) <= 0) {
            return '';
        }

        $additionalDataString = json_encode($this->additionalData);
        if (!$additionalDataString) {
            return '';
        }

        return $additionalDataString;
    }

    public function getUseHttps(): bool
    {
        return $this->useHttps;
    }

    public function setUseHttps(bool $useHttps): void
    {
        $this->useHttps = $useHttps;
    }
}
?>