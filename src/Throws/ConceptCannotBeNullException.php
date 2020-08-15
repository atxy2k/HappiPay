<?php


namespace Atxy2k\HappyPay\Throws;

use Exception;

class ConceptCannotBeNullException extends Exception
{
    protected $message = 'Concept can not be null';
}