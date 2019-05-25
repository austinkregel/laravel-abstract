# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kregel/abstract.svg?style=flat-square)](https://packagist.org/packages/kregel/:package_name)
[![Build Status](https://img.shields.io/travis/kregel/abstract/master.svg?style=flat-square)](https://travis-ci.org/kregel/:package_name)
[![Quality Score](https://img.shields.io/scrutinizer/g/kregel/abstract.svg?style=flat-square)](https://scrutinizer-ci.com/g/kregel/:package_name)
[![Total Downloads](https://img.shields.io/packagist/dt/kregel/abstract.svg?style=flat-square)](https://packagist.org/packages/kregel/:package_name)


This is where your description should go. Try and limit it to a paragraph or two.

## Installation

You can install the package via composer:

```bash
composer require kregel/abstract
```

## Usage
Publish the vendor files. Inside the newly published `AbstractRouteServiceProvider` file you'll want to add your models to the `ROUTE_BINDINGS` array. Should looks something like
```php
public const ROUTE_BINDINGS = [
    'users' => User::class
];
```

`users` could be anything you'd like, it just matters when you try to hit the endpoint. 

Beyond that, you're able to limit access to the routes via the baked in Laravel policies. You'll just have to ensure to add an extra method for the `index` method.

If you'd like to just bypass all the Laravel policies for the routes you can do that by adding the `LaravelAbstract::bypass(true)` to the abstract service provider.

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email github@austinkregel.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
