<?php

namespace madmis\CoingeckoApi\Endpoint;

use madmis\CoingeckoApi\Api;
use madmis\CoingeckoApi\Model\ExchangeRate;
use madmis\CoingeckoApi\Model\Price;
use madmis\ExchangeApi\Endpoint\AbstractEndpoint;
use madmis\ExchangeApi\Endpoint\EndpointInterface;
use madmis\ExchangeApi\Exception\ClientException;

/**
 * Class PublicEndpoint
 * @package madmis\CoingeckoApi\Endpoint
 */
class PublicEndpoint extends AbstractEndpoint implements EndpointInterface
{
    /**
     * https://www.coingecko.com/coins/currency_exchange_rates.json
     * @param bool $mapping
     * @return array|ExchangeRate[]
     */
    public function getExchangeRates(bool $mapping = false)
    {
        $response = $this->sendRequest(
            Api::GET,
            $this->getApiUrn(['coins', 'currency_exchange_rates.json'])
        );

        if ($mapping) {
            $base = array_filter($response['rates'], function ($val) {
                return $val === null;
            });
            reset($base);
            $baseCurrency = $base ? key($base) : Api::QUOTE_BTC;

            $formatted = [];
            foreach ($response['rates'] as $key => $val) {
                if ($key !== $baseCurrency) {
                    $formatted[] = [
                        'currency' => $key,
                        'baseCurrency' => $baseCurrency,
                        'rate' => (float)$val,
                        'unit' => $response['units'][$key] ?? '',
                    ];
                }
            }

            $response = $this->deserializeItems($formatted, ExchangeRate::class);
        }

        return $response;
    }

    /**
     * https://www.coingecko.com/en/price_charts/bitcoin/usd/24_hours.json
     * @param string $base base currency {@link \madmis\CoingeckoApi\Api::BASE_}
     * @param string $quote quote currency {@link \madmis\CoingeckoApi\Api::QUOTE_}
     * @param string $period data period {@link \madmis\CoingeckoApi\Api::PERIOD_}
     * @param bool $mapping
     * @return array|Price[]
     * @throws ClientException
     */
    public function priceCharts(string $base, string $quote, string $period, bool $mapping = false)
    {
        if ($period !== Api::PERIOD_MAX) {
            $urnParams = ['en', 'price_charts', $base, $quote, $period];
        } else {
            $urnParams = ['en', 'chart', $base, $quote];
        }

        $response = $this->sendRequest(
            Api::GET,
            sprintf('%s.json', $this->getApiUrn($urnParams))
        );

        if ($mapping) {
            $response = $this->deserializeItems(array_map(function ($item) {
                return [
                    'date' => (float)chunk_split((int)$item[0], 10, '.'),
                    'price' => $item[1]
                ];
            }, $response['stats']), Price::class);
        }

        return $response;
    }

    /**
     * @param string $method Http::GET|POST
     * @param string $uri
     * @param array $options Request options to apply to the given
     *                                  request and to the transfer.
     * @return array response
     * @throws ClientException
     */
    protected function sendRequest(string $method, string $uri, array $options = []): array
    {
        $request = $this->client->createRequest($method, $uri);

        return $this->processResponse(
            $this->client->send($request, $options)
        );

    }
}
