<?php

namespace Matthewbdaly\LaravelCart\Services;

use Matthewbdaly\LaravelCart\Contracts\Services\Cart as CartContract;
use Illuminate\Contracts\Session\Session;

class Cart implements CartContract
{
    protected $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function insert(array $item)
    {
        return $this->session->put('laravel_shopping_cart', $item);
    }
}
