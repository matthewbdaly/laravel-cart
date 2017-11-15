<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Matthewbdaly\LaravelCart\Services\Cart;
use Mockery as m;

class CartTest extends TestCase
{
    public function testCanAddItemToCart()
    {
        $session = m::mock('Illuminate\Contracts\Session\Session');
        $cart = new Cart($session);
        $cart->insert([
            'qty'     => 1,
            'price'   => 39.95,
            'name'    => 'T-Shirt',
            'options' => array('Size' => 'L', 'Color' => 'Red')
        ]);
    }
}
