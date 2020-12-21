<?php

namespace Blsky\Payfast\Facades;

use Illuminate\Support\Facades\Facade;

class PayfastCart extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'payfastcart';
    }
}
