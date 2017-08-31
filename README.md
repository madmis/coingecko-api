# Coingecko REST API PHP Client

[![SensioLabsInsight][sensiolabs-insight-image]][sensiolabs-insight-link]
[![Build Status][testing-image]][testing-link]
[![Coverage Status][coverage-image]][coverage-link]
[![Latest Stable Version][stable-image]][package-link]
[![Total Downloads][downloads-image]][package-link]
[![License][license-image]][license-link]

This API client will help you interact with Coingecko data. 
 

## License

MIT License


## Contributing
To create new endpoint - [create issue](https://github.com/madmis/coingecko-api/issues/new) 
or [create pull request](https://github.com/madmis/coingecko-api/compare)


## Install
    
    composer require madmis/coingecko-api 1.0.*


## Usage
```php
$api = new CoingeckoApi();
$timestamp = $api->shared()->priceCharts(Api::BASE_ETH, Api::QUOTE_USD, Api::PERIOD_24HOURS, true));
```
### Mapping

Each endpoint response can be received as `array` or as `object`.

To use mapping response to `object` set parameter `$mapping` to `true`. 

```php
$issue = $api->shared()->priceCharts(Api::BASE_ETH, Api::QUOTE_USD, Api::PERIOD_24HOURS, true));

// Result
[
    {
    class madmis\CoingeckoApi\Model\Price {
        protected $price => 379.62131925945
        protected $date => DateTime
      }
    
    },
    ...
] 
```

### Error handling
Each client request errors wrapped to custom exception **madmis\ExchangeApi\Exception\ClientException**  

```php
class madmis\ExchangeApi\Exception\ClientException {
  private $request => class GuzzleHttp\Psr7\Request
  private $response => NULL
  protected $message => "cURL error 7: Failed to connect to 127.0.0.1 port 8080: Connection refused (see http://curl.haxx.se/libcurl/c/libcurl-errors.html)"
  ...
}
```

**ClientException** contains original **request object** and **response object** if response available

```php
class madmis\ExchangeApi\Exception\ClientException {
  private $request => class GuzzleHttp\Psr7\Request 
  private $response => class GuzzleHttp\Psr7\Response {
    private $reasonPhrase => "Unauthorized"
    private $statusCode => 401
    ...
  }
  protected $message => "Client error: 401"
  ...  
}
```

So, to handle errors use try/catch

```php
try {
    $api->signed()->activeOrders(Http::PAIR_ETHUAH, true);
} catch (madmis\ExchangeApi\Exception\ClientException $ex) {
    // any actions (log error, send email, ...) 
}
``` 


## Running the tests
To run the tests, you'll need to install [phpunit](https://phpunit.de/). 
Easiest way to do this is through composer.

    composer install

### Running Unit tests

    php vendor/bin/phpunit -c phpunit.xml.dist


[testing-link]: https://travis-ci.org/madmis/coingecko-api
[testing-image]: https://travis-ci.org/madmis/coingecko-api.svg?branch=master

[sensiolabs-insight-link]: https://insight.sensiolabs.com/projects/b767dd02-927d-4340-abee-ea7f10bea981
[sensiolabs-insight-image]: https://insight.sensiolabs.com/projects/b767dd02-927d-4340-abee-ea7f10bea981/mini.png

[package-link]: https://packagist.org/packages/madmis/coingecko-api
[downloads-image]: https://poser.pugx.org/madmis/coingecko-api/downloads
[stable-image]: https://poser.pugx.org/madmis/coingecko-api/v/stable
[license-image]: https://poser.pugx.org/madmis/coingecko-api/license
[license-link]: https://packagist.org/packages/madmis/coingecko-api

[coverage-link]: https://coveralls.io/github/madmis/coingecko-api?branch=master
[coverage-image]: https://coveralls.io/repos/github/madmis/coingecko-api/badge.svg?branch=master

