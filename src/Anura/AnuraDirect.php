<?php
declare(strict_types=1);
namespace Anura;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Client;
use Exception;
use Anura\DirectResult;
use Anura\DirectRequest;
use Anura\Exception\AnuraException;
use Anura\Exception\AnuraClientException;
use Anura\Exception\AnuraServerException;

/**
 * API client for Anura Direct.
 */
class AnuraDirect
{
    private string $instance;
    private bool $useHttps;
    private string $apiUrl;
    private string $source = '';
    private string $campaign = '';
    private Client $client;

    public function __construct(string $instance, bool $useHttps = true)
    {
        $this->instance = $instance;
        $this->useHttps = $useHttps;
        $this->apiUrl = $useHttps ? 'https://direct.anura.io/direct.json' : 'http://direct.anura.io/direct.json';
        $this->client = new Client();
    }

    /**
     * Gets a result from Anura Direct.
     */
    public function getResult(DirectRequest $request)
    {
        $params = [
            'instance' => $this->instance,
            'ip' => $request->getIpAddress(),
        ];

        if ($request->getSource()) $params['source'] = $request->getSource();
        if ($request->getCampaign()) $params['campaign'] = $request->getCampaign();
        if ($request->getUserAgent()) $params['ua'] = $request->getUserAgent();
        if ($request->getApp()) $params['app'] = $request->getApp();
        if ($request->getDevice()) $params['device'] = $request->getDevice();

        $additionalData = $request->getAdditionalData();
        if ($additionalData && $additionalData->size() > 0) {
            $params['additional'] = $additionalData->__toString();
        }

        $response = null;
        try {
            $response = $this->client->request('GET', $this->apiUrl . '?' . http_build_query($params));
        } catch (ClientException $e) {
            $body = json_decode($e->getResponse()->getBody()->getContents(), true);
            $error = $body['error'] ?? 'Anura Client-Side Error: ' . $e->getResponse()->getStatusCode();
            throw new AnuraClientException($error);
        } catch(ServerException $e) {
            $body = json_decode($e->getResponse()->getBody()->getContents(), true);
            $error = $body['error'] ?? 'Anura Server-Side Error: ' . $e->getResponse()->getStatusCode();
            throw new AnuraServerException($error);
        } catch (Exception $e) {
            throw new AnuraException($e->getMessage());
        }

        $result = json_decode($response->getBody()->getContents(), true);
        if (!$result) {
            throw new AnuraException("Successfully got response from Anura Direct API, but could not parse it.");
        }

        $directResult = new DirectResult(
            $result['result'] ?? '',
            $result['mobile'],
            $result['rule_sets'] ?? null,
            $result['invalid_traffic_type'] ?? null
        );

        return $directResult;
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

    public function getUseHttps(): bool
    {
        return $this->useHttps;
    }

    public function setUseHttps(bool $useHttps): void
    {
        $this->apiUrl = $useHttps ? 'https://direct.anura.io/direct.json' : 'http://direct.anura.io/direct.json';
        $this->useHttps = $useHttps;
    }
}
?>