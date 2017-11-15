<?php

namespace Matthewbdaly\LaravelCart\Contracts\Services;

interface UniqueId
{
    /**
     * Generate unique ID
     *
     * @return string
     */
    public function get();
}
