<?php

namespace Matthewbdaly\LaravelCart\Services;

use Matthewbdaly\LaravelCart\Contracts\Services\UniqueId as UniqueIdContract;

class UniqueId implements UniqueIdContract
{
    public function get()
    {
        return uniqid();
    }
}
