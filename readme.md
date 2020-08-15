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

Antes de generar una URL usted necesita crear un objeto <code>HappiPayRequest</code> de la siguiente
manera:

``` php
$payment_id = Str::uuid()->toString();
$amount = 100;
$payment = HappiPayRequest::create($amount, $payment_id);
```
El objeto HappyPayRequest contiene la información que es posible de enviar al Api de 
HappiPay.

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
