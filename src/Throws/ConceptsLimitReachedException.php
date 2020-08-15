<?php


namespace Atxy2k\HappiPay\Throws;

use Exception;
class ConceptsLimitReachedException extends Exception
{
    protected $message = 'Concepts limit is reached!';
}