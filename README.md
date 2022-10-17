# Simple Notification

[![Software License][ico-license]](LICENSE.md)

## About

The `Simple Notification` is a package to send notification when has an error .

##### [Tutorial how create composer package](https://cirelramos.blogspot.com/2022/04/how-create-composer-package.html)

## Installation

Require the `litermi/simple-notification` package in your `composer.json` and update your dependencies:
```sh
composer require litermi/simple-notification
```


## Configuration

set provider

```php
'providers' => [
    // ...
    Litermi\SimpleNotification\Providers\ServiceProvider::class,
],
```


The defaults are set in `config/simple-notification.php`. Publish the config to copy the file to your own config:
```sh
php artisan vendor:publish --provider="Litermi\SimpleNotification\Providers\ServiceProvider"
```

> **Note:** this is necessary to you can change default config



## Usage
The default notifications are set as Log type if the warning() or error() methods are not specified.
```php
$extraValues['test'] = 1;
SimpleNotificationFacade::email()->slack()->notification('message notification', $extraValues);
SimpleNotificationFacade::email()->slack()->warning()->notification('message notification', $extraValues);
SimpleNotificationFacade::email()->slack()->error()->notification('message notification', $extraValues);


```


## License

Released under the MIT License, see [LICENSE](LICENSE).


[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square

