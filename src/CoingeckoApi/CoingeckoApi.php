<?php

namespace madmis\CoingeckoApi;

use madmis\CoingeckoApi\Endpoint\PublicEndpoint;
use madmis\ExchangeApi\Client\ClientInterface;
use madmis\ExchangeApi\Client\GuzzleClient;
use madmis\ExchangeApi\Endpoint\EndpointFactory;
use madmis\ExchangeApi\Endpoint\EndpointInterface;

/**
 * Class CoingeckoApi
 * @package madmis\CoingeckoApi
 */
class CoingeckoApi
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var EndpointFactory
     */
    private $endpointFactory;

    /**
     * @param string $baseUri example: https://www.coingecko.com
     * @param string $apiUrn example: /
     * @param array $options extra parameters
     */
    public function __construct(string $baseUri = 'https://www.coingecko.com', string $apiUrn = '/', array $options = [])
    {
        $this->client = new GuzzleClient($baseUri, $apiUrn, $options);
        $this->endpointFactory = new EndpointFactory();
    }

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client): void
    {
        $this->client = $client;
    }

    /**
     * @return ClientInterface
     */
    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    /**
     * @return PublicEndpoint|EndpointInterface
     */
    public function shared(): PublicEndpoint
    {
        return $this
            ->endpointFactory
            ->getEndpoint(PublicEndpoint::class, $this->client);
    }

}
