<picture>
  <source media="(prefers-color-scheme: dark)" srcset="https://static.openfoodfacts.org/images/logos/off-logo-horizontal-dark.png?refresh_github_cache=1">
  <source media="(prefers-color-scheme: light)" srcset="https://static.openfoodfacts.org/images/logos/off-logo-horizontal-light.png?refresh_github_cache=1">
  <img height="48" src="https://static.openfoodfacts.org/images/logos/off-logo-horizontal-light.svg">
</picture>

# Laravel Open Food Facts API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/openfoodfacts/openfoodfacts-laravel.svg?style=flat-square)](https://packagist.org/packages/openfoodfacts/openfoodfacts-laravel)
[![Code Coverage](https://scrutinizer-ci.com/g/openfoodfacts/openfoodfacts-laravel/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/openfoodfacts/openfoodfacts-laravel/?branch=master)
[![Quality Score](https://img.shields.io/scrutinizer/g/openfoodfacts/openfoodfacts-laravel.svg?style=flat-square)](https://scrutinizer-ci.com/g/openfoodfacts/openfoodfacts-laravel)

This package provides a convenient wrapper to the [Open Food Facts API](https://en.wiki.openfoodfacts.org/API) for Laravel applications.

## Requirements

- PHP 8.1+
- Laravel 9.x, 10.x, 11.x

## Installation

You can install the package via composer:

```bash
composer require openfoodfacts/openfoodfacts-laravel
```

#### Legacy support

- PHP 8.0 (Laravel <=9.x): `composer require "openfoodfacts/openfoodfacts-laravel:^0.3"`
- PHP 7.2-7.4.x (Laravel 5.7-8.x): `composer require "openfoodfacts/openfoodfacts-laravel:^0.2"`


## Usage

#### Find product details by barcode
``` php
OpenFoodFacts::barcode('20203467');
```
it returns an array with product details:
```
Array
(
    [product_name] => Cantuccini with hazelnuts
    [image_url] => https://static.openfoodfacts.org/images/products/20203467/front_fr.4.400.jpg
    ...    
)    
```

#### Find products that match a search term:
``` php
$collection = OpenFoodFacts::find('Coca Cola Zero');

// returns a Illuminate\Support\Collection of arrays with details of each product found
```


## Contributing
You're very welcome to contribute. We coordinate on the Open Food Facts slack, on the #PHP channel : https://slack.openfoodfacts.org
Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Third party applications
If you use this SDK, feel free to open a PR to add your application in this list.

## Authors
