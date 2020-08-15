<?php


namespace Atxy2k\HappiPay\Throws;

use Exception;
class InvalidPaymentType extends Exception
{
    protected $message = 'Payment type is not supported';
}