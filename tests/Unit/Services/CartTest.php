<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Matthewbdaly\LaravelCart\Services\Cart;
use Mockery as m;

class CartTest extends TestCase
{
    /**
     * @dataProvider itemProvider
     */
    public function testCanAddItemToCart($data)
    {
        $session = m::mock('Illuminate\Contracts\Session\Session');
        $session->shouldReceive('put')->with('laravel_shopping_cart', $data)->once();
        $cart = new Cart($session);
        $this->assertNull($cart->insert($data));
    }

    /**
     * @dataProvider arrayProvider
     */
    public function testCanAddMultipleItemsToCart($data)
    {
        $session = m::mock('Illuminate\Contracts\Session\Session');
        $session->shouldReceive('put')->with('laravel_shopping_cart', $data[0])->once();
        $session->shouldReceive('put')->with('laravel_shopping_cart', $data[1])->once();
        $cart = new Cart($session);
        $this->assertNull($cart->insert($data));
    }

    public function itemProvider()
    {
        return [[[
            'qty'     => 1,
            'price'   => 39.95,
            'name'    => 'T-Shirt',
            'options' => ['Size' => 'L', 'Color' => 'Red']
        ]]];
    }

    public function arrayProvider()
    {
        return [[[[
            'qty'     => 1,
            'price'   => 39.95,
            'name'    => 'T-Shirt',
            'options' => ['Size' => 'L', 'Color' => 'Red']
        ], [
            'qty'     => 2,
            'price'   => 49.95,
            'name'    => 'Shirt',
            'options' => ['Size' => 'M', 'Color' => 'Blue']
        ]]]];
    }
}
