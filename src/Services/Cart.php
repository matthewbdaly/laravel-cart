<?php

namespace Matthewbdaly\LaravelCart\Services;

use Matthewbdaly\LaravelCart\Contracts\Services\Cart as CartContract;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Collection;

class Cart implements CartContract
{
    protected $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function insert(array $item)
    {
        $content = new Collection($this->session->get('laravel_shopping_cart'));
        if ($this->hasStringKeys($item)) {
            $content->push($item);
        } else {
            foreach ($item as $subitem) {
                $content->push($subitem);
            }
        }
        return $this->session->put('laravel_shopping_cart', $content->toArray());
    }

    private function hasStringKeys(array $items) {
        return count(array_filter(array_keys($items), 'is_string')) > 0;
    }
}
