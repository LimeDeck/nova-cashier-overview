# A Laravel Nova resource tool to manage your Cashier (Stripe) subscriptions

[![Latest Version on Packagist](https://img.shields.io/packagist/v/limedeck/nova-cashier-overview.svg?style=flat-square)](https://packagist.org/packages/limedeck/nova-cashier-overview)
[![CircleCI](https://travis-ci.org/LimeDeck/nova-cashier-overview.svg?branch=master)](https://travis-ci.org/LimeDeck/nova-cashier-overview)
[![StyleCI](https://github.styleci.io/repos/223514784/shield?branch=master)](https://github.styleci.io/repos/223514784)
[![Total Downloads](https://img.shields.io/packagist/dt/limedeck/nova-cashier-overview.svg?style=flat-square)](https://packagist.org/packages/limedeck/nova-cashier-overview)

This [Nova](https://nova.laravel.com) tool lets you:

- view a database subscription (subscription name is a parameter)
- view Stripe subscription details
- view invoices for a given subscription with a downloadable link
- change a subscription plan
- cancel a subscription
- resume a subscription
- avoid unnecessary Stripe API call when you load a resource to quickly get a status information and dive deeper if you need it

### Default view of the subscription

![screenshot of the initial Cashier overview tool](https://raw.githubusercontent.com/LimeDeck/nova-cashier-overview/master/screenshots/initial.png)

### Expanded view of the subscription

![screenshot of the expanded Cashier overview tool](https://raw.githubusercontent.com/LimeDeck/nova-cashier-overview/master/screenshots/expanded.png)

## Disclaimer

This package has been heavily inspired by [themsaid/nova-cashier-manager](https://github.com/themsaid/nova-cashier-manager) and was created to be in sync with latest changes in Cashier as well as to optimize default loads by avoiding a Stripe API request unless it's needed. Structure of this repository was inspired by [spatie/skeleton-nova-tool](https://github.com/spatie/skeleton-nova-tool).

## Installation

You can install the nova tool in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require limedeck/nova-cashier-overview
```

Next up, you use the resource tool with Nova. This is typically done in the `fields` method of the desired Nova Resource.

```php
use LimeDeck\NovaCashierOverview\Subscription;

// ...

public function fields(Request $request)
{
    return [
        ID::make()->sortable(),

        ...

        Subscription::make(),

        // if you want to display a specific subscription or multiple
        Subscription::make('a-fancy-subscription-name'),

        ...
    ];
}
```

To translate the nova tool use:

```bash
php artisan vendor:publish --provider="LimeDeck\NovaCashierOverview\Providers\CashierOverviewServiceProvider"
```

Inside your /resources/lang/vendor/nova-cashier-overview you can create your custom translations.

### Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email rudolf@limedeck.io instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
