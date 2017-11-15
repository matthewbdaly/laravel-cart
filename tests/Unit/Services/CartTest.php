<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Matthewbdaly\LaravelCart\Services\Cart;
use Mockery as m;

class CartTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testCanAddItemToCart($data)
    {
        $session = m::mock('Illuminate\Contracts\Session\Session');
        $session->shouldReceive('put')->with('laravel_shopping_cart', $data);
        $cart = new Cart($session);
        $this->assertNull($cart->insert($data));
    }

    public function dataProvider()
    {
        return [[[
            'qty'     => 1,
            'price'   => 39.95,
            'name'    => 'T-Shirt',
            'options' => array('Size' => 'L', 'Color' => 'Red')
        ]]];
    }
}
