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
        if ($this->hasStringKeys($item)) {
            return $this->session->put('laravel_shopping_cart', $item);
        } else {
            foreach ($item as $subitem) {
                $this->insert($subitem);
            }
        }
    }

    private function hasStringKeys(array $items) {
        return count(array_filter(array_keys($items), 'is_string')) > 0;
    }
}
