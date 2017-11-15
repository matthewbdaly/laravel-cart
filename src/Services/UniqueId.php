<?php

namespace Matthewbdaly\LaravelCart\Services;

use Matthewbdaly\LaravelCart\Contracts\Services\UniqueId as UniqueIdContract;

/**
 * Generates unique ID's
 */
class UniqueId implements UniqueIdContract
{
    /**
     * Generate unique ID
     *
     * @return string
     */
    public function get()
    {
        return uniqid();
    }
}
