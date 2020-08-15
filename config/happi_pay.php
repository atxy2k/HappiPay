<?php

use Atxy2k\HappiPay\Constants\Environment;
use Atxy2k\HappiPay\Constants\HappiPay;

return [
    'endpoint' => 'https://link.happipay.mx/generar',
    //
    'credentials' => [
        'username' => env(Environment::USERNAME, null),
        'password' => env(Environment::PASSWORD, null)
    ],
    'options' => [
        'tp' => env(Environment::HAPPI_PAY_TP, HappiPay::TP_UNA_SOLA_EXHIBICION),
        'currency' => env(Environment::HAPPI_PAY_CURRENCY, HappiPay::MONEDA),
        'notify_users' => env(Environment::HAPPI_PAY_NOTIFY, HappiPay::NO_NOTIFICAR_USUARIO),
        '3ds' => env(Environment::HAPPI_PAY_3DS, HappiPay::SEGURIDAD_CON_3DS),
        'expiration_time' => env(Environment::HAPPI_PAY_EXPIRATION_TIME, null),
        'delegate_commissions' => env(Environment::HAPPI_PAY_DELEGATE_COMMISSIONS, HappiPay::COMISION_TRANSFERIDA),
        'concepts_limit' => env(Environment::HAPPI_PAY_CONCEPTS_LIMIT, 5)
    ]
];