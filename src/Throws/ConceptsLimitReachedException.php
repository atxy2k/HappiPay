<?php


namespace Atxy2k\HappyPay\Throws;

use Exception;
class ConceptsLimitReachedException extends Exception
{
    protected $message = 'Concepts limit is reached!';
}