<?php

namespace Atxy2k\HappiPay\Facades;

use Illuminate\Support\Facades\Facade;

class HappyPay extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'happypay';
    }
}
