<?php

namespace Matthewbdaly\LaravelCart\Contracts\Services;

interface Cart
{
    public function insert(array $item);

    public function all();
}
