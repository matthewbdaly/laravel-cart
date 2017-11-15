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
        $session->shouldReceive('get')->with('Matthewbdaly\LaravelCart\Services\Cart')->once()->andReturn([]);
        $session->shouldReceive('put')->with('Matthewbdaly\LaravelCart\Services\Cart', [$data])->once();
        $uniqid = m::mock('Matthewbdaly\LaravelCart\Contracts\Services\UniqueId');
        $cart = new Cart($session, $uniqid);
        $this->assertNull($cart->insert($data));
    }

    /**
     * @dataProvider arrayProvider
     */
    public function testCanAddMultipleItemsToCart($data)
    {
        $session = m::mock('Illuminate\Contracts\Session\Session');
        $session->shouldReceive('get')->with('Matthewbdaly\LaravelCart\Services\Cart')->once()->andReturn([]);
        $session->shouldReceive('put')->with('Matthewbdaly\LaravelCart\Services\Cart', $data)->once();
        $uniqid = m::mock('Matthewbdaly\LaravelCart\Contracts\Services\UniqueId');
        $cart = new Cart($session, $uniqid);
        $this->assertNull($cart->insert($data));
    }

    /**
     * @dataProvider arrayProvider
     */
    public function testCanAddToCartWhenItemsAlreadyExist($data)
    {
        $session = m::mock('Illuminate\Contracts\Session\Session');
        $session->shouldReceive('get')->with('Matthewbdaly\LaravelCart\Services\Cart')->once()->andReturn([$data[0]]);
        $session->shouldReceive('put')->with('Matthewbdaly\LaravelCart\Services\Cart', $data)->once();
        $uniqid = m::mock('Matthewbdaly\LaravelCart\Contracts\Services\UniqueId');
        $cart = new Cart($session, $uniqid);
        $this->assertNull($cart->insert($data[1]));
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
