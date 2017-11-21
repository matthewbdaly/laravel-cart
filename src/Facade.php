<?php

namespace Matthewbdaly\LaravelCart;

use Illuminate\Support\Facades\Facade as BaseFacade;

/**
 * Facade for the SMS provider
 */
class Facade extends BaseFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Matthewbdaly\LaravelCart\Contracts\Services\Cart';
    }
}
