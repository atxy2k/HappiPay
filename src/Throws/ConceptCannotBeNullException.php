<?php


namespace Atxy2k\HappiPay\Throws;

use Exception;

class ConceptCannotBeNullException extends Exception
{
    protected $message = 'Concept can not be null';
}