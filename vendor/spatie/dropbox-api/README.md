# A minimal implementation of Dropbox API v2

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/dropbox-api.svg?style=flat-square)](https://packagist.org/packages/spatie/dropbox-api)
[![Build Status](https://img.shields.io/travis/spatie/dropbox-api/master.svg?style=flat-square)](https://travis-ci.org/spatie/dropbox-api)
[![StyleCI](https://styleci.io/repos/88621289/shield?branch=master)](https://styleci.io/repos/88621289)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/dropbox-api.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/dropbox-api)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/dropbox-api.svg?style=flat-square)](https://packagist.org/packages/spatie/dropbox-api)

This is a minimal PHP implementation of the [Dropbox API v2](https://www.dropbox.com/developers/documentation/http/overview). It contains only the methods needed for [our flysystem-dropbox adapter](https://github.com/spatie/flysystem-dropbox). We are open however to PRs that add extra methods to the client. 

Here are a few examples on how you can use the package:

```php
$client = new Spatie\Dropbox\Client($authorizationToken);

//create a folder
$client->createFolder($path);

//list a folder
$client->listFolder($path);

//get a temporary link
$client->getTemporaryLink($path);
```

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/dropbox-api.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/dropbox-api)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

``` bash
composer require spatie/dropbox-api
```

## Usage

The first thing you need to do is get an authorization token at Dropbox. Unlike [other companies](https://google.com) Dropbox has made this very easy. You can just generate a token in the [App Console](https://www.dropbox.com/developers/apps) for any Dropbox API app. You'll find more info at [the Dropbox Developer Blog](https://blogs.dropbox.com/developers/2014/05/generate-an-access-token-for-your-own-account/).

With an authorization token you can instantiate a `Spatie\Dropbox\Client`.

```php
$client = new Spatie\Dropbox\Client($authorizationToken);
```

or alternatively you can authenticate as an App using your App Key & Secret.

```php
$client = new Spatie\Dropbox\Client([$appKey, $appSecret]);
```

If you only need to access the public endpoints you can instantiate `Spatie\Dropbox\Client` without any arguments.

```php
$client = new Spatie\Dropbox\Client();
```

Look in [the source code of `Spatie\Dropbox\Client`](https://github.com/spatie/dropbox-api/blob/master/src/Client.php) to discover the methods you can use.

If you do not find your favorite method, you can directly use the `contentEndpointRequest` and `rpcEndpointRequest` functions.

```php
public function contentEndpointRequest(string $endpoint, array $arguments, $body): ResponseInterface

public function rpcEndpointRequest(string $endpoint, array $parameters): array
```

Here's an example:

```php
$client->rpcEndpointRequest('search', ['path' => '', 'query' => 'bat cave']);
```

If you need to change the subdomain of the endpoint URL used in the API request, you can prefix the endpoint path with `subdomain::`.

Here's an example:

```php
$client->rpcEndpointRequest('content::files/get_thumbnail_batch', $parameters);
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package (it's [MIT-licensed](LICENSE.md)), but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Kruikstraat 22, 2018 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Alex Vanderbist](https://github.com/AlexVanderbist)
- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
