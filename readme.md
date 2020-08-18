# Happi Pay

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]

Un simple wrapper para agilizar la generación de urls a traves de Happi Pay

## Installation

Via Composer

``` bash
$ composer require atxy2k/happi-pay
```

## Usage
Antes que nada exporte la configuracion para tener acceso a la configuración predeterminada de happy
pay:
```shell
php artisan vendor:publish --provider=Atxy2k\\HappiPay\\HappiPayServiceProvider
```
Posteriormente, agregue las variables siguientes a su archivo <code>.env</code>

```shell
HAPPI_PAY_USERNAME=YOUR_API_HAPPI_PAY_USERNAME
HAPPI_PAY_PASSWORD=YOUR_API_HAPPI_PAY_PASSWORD
```
Ahora está listo para generar urls, para esto, necesita antes que nada, crear una instancia
 del objeto <code>HappiPayRequest</code> de la siguiente
manera:

``` php
$payment_id = Str::uuid()->toString();
$amount = 100;
$payment = HappiPayRequest::create($amount, $payment_id);
```
El objeto HappyPayRequest contiene la información que es posible de enviar al Api de 
HappiPay. Una vez que lo tenga listo, puede obtener el link haciendo uso del facade
<code>HappiPay</code>

## Testing
Antes de ejecutar las pruebas, es necesario colocar en las variables del entorno 
las credenciales del usuario de HappiPay que sean de tipo de API.

En sistemas basados en unix usted puede hacerlo de la siguiente manera:
``` bash
export HAPPI_PAY_USERNAME="YOUR_USERNAME"
export HAPPI_PAY_PASSWORD="YOUR_PASSWORD_HERE"
```
Desafortunadamente no tengo conocimiendo de como hacerlo en windows, se aceptan pull request al 
respecto para nutrir la documentación.

Teniendo lo anterior listo, puede hacer pruebas ejecutando

``` bash
$ composer test
```
O de la manera tradicional
``` bash
$ vendor/bin/phpunit
```

## Creditos

- [atxy2k][link-author]

[ico-version]: https://img.shields.io/packagist/v/atxy2k/happypay.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/atxy2k/happypay.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/atxy2k/happypay/master.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/atxy2k/happy-pay
[link-downloads]: https://packagist.org/packages/atxy2k/happy-pay
[link-travis]: https://travis-ci.org/atxy2k/happy-pay
[link-author]: https://github.com/atxy2k
