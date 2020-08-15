<?php

use Atxy2k\HappyPay\Constants\Environment;
use Atxy2k\HappyPay\Constants\HappyPay;

return [
    'endpoint' => 'https://link.happipay.mx/generar',
    //
    'credentials' => [
        'username' => env(Environment::USERNAME, null),
        'password' => env(Environment::PASSWORD, null)
    ],
    'options' => [
        'tp' => env(Environment::HAPPY_PAY_TP, HappyPay::TP_UNA_SOLA_EXHIBICION),
        'currency' => env(Environment::HAPPY_PAY_CURRENCY, HappyPay::MONEDA),
        'notify_users' => env(Environment::HAPPY_PAY_NOTIFY, HappyPay::NO_NOTIFICAR_USUARIO),
        '3ds' => env(Environment::HAPPY_PAY_3DS, HappyPay::SEGURIDAD_CON_3DS),
        'expiration_time' => env(Environment::HAPPY_PAY_EXPIRATION_TIME, null),
        'delegate_commissions' => env(Environment::HAPPY_PAY_DELEGATE_COMMISSIONS, HappyPay::COMISION_TRANSFERIDA),
        'concepts_limit' => env(Environment::HAPPY_PAY_CONCEPTS_LIMIT, 5)
    ]
];