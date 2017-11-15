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
        $formattedData = $data;
        $formattedData['row_id'] = 'my_row_id_1';
        $session = m::mock('Illuminate\Contracts\Session\Session');
        $session->shouldReceive('get')->with('Matthewbdaly\LaravelCart\Services\Cart')->once()->andReturn([]);
        $session->shouldReceive('put')->with('Matthewbdaly\LaravelCart\Services\Cart', [$formattedData])->once();
        $uniqid = m::mock('Matthewbdaly\LaravelCart\Contracts\Services\UniqueId');
        $uniqid->shouldReceive('get')->once()->andReturn('my_row_id_1');
        $cart = new Cart($session, $uniqid);
        $this->assertNull($cart->insert($data));
    }

    /**
     * @dataProvider arrayProvider
     */
    public function testCanAddMultipleItemsToCart($data)
    {
        $formattedData = $data;
        $formattedData[0]['row_id'] = 'my_row_id_1';
        $formattedData[1]['row_id'] = 'my_row_id_2';
        $session = m::mock('Illuminate\Contracts\Session\Session');
        $session->shouldReceive('get')->with('Matthewbdaly\LaravelCart\Services\Cart')->once()->andReturn([]);
        $session->shouldReceive('put')->with('Matthewbdaly\LaravelCart\Services\Cart', $formattedData)->once();
        $uniqid = m::mock('Matthewbdaly\LaravelCart\Contracts\Services\UniqueId');
        $uniqid->shouldReceive('get')->once()->andReturn('my_row_id_1');
        $uniqid->shouldReceive('get')->once()->andReturn('my_row_id_2');
        $cart = new Cart($session, $uniqid);
        $this->assertNull($cart->insert($data));
    }

    /**
     * @dataProvider arrayProvider
     */
    public function testCanAddToCartWhenItemsAlreadyExist($data)
    {
        $olditem = $data[0];
        $olditem['row_id'] = 'my_row_id_1';
        $newitem = $data[1];
        $newitem['row_id'] = 'my_row_id_2';
        $session = m::mock('Illuminate\Contracts\Session\Session');
        $session->shouldReceive('get')->with('Matthewbdaly\LaravelCart\Services\Cart')->once()->andReturn([$olditem]);
        $session->shouldReceive('put')->with('Matthewbdaly\LaravelCart\Services\Cart', [$olditem, $newitem])->once();
        $uniqid = m::mock('Matthewbdaly\LaravelCart\Contracts\Services\UniqueId');
        $uniqid->shouldReceive('get')->once()->andReturn('my_row_id_2');
        $cart = new Cart($session, $uniqid);
        $this->assertNull($cart->insert($data[1]));
    }

    /**
     * @dataProvider arrayProvider
     */
    public function testCanGetAllItems($data)
    {
        $session = m::mock('Illuminate\Contracts\Session\Session');
        $session->shouldReceive('get')->with('Matthewbdaly\LaravelCart\Services\Cart')->once()->andReturn($data);
        $uniqid = m::mock('Matthewbdaly\LaravelCart\Contracts\Services\UniqueId');
        $cart = new Cart($session, $uniqid);
        $this->assertEquals($data, $cart->all());
    }

    /**
     * @dataProvider arrayProvider
     */
    public function testCanGetItem($data)
    {
        $data[0]['row_id'] = 'my_row_id_1';
        $data[1]['row_id'] = 'my_row_id_2';
        $newdata = $data;
        $newdata[0]['qty'] = 2;
        $session = m::mock('Illuminate\Contracts\Session\Session');
        $session->shouldReceive('get')->with('Matthewbdaly\LaravelCart\Services\Cart')->once()->andReturn($data);
        $uniqid = m::mock('Matthewbdaly\LaravelCart\Contracts\Services\UniqueId');
        $cart = new Cart($session, $uniqid);
        $this->assertEquals($data[0], $cart->get('my_row_id_1'));
    }

    /**
     * @dataProvider arrayProvider
     */
    public function testCanUpdateItem($data)
    {
        $data[0]['row_id'] = 'my_row_id_1';
        $data[1]['row_id'] = 'my_row_id_2';
        $newdata = $data;
        $newdata[0]['qty'] = 2;
        $session = m::mock('Illuminate\Contracts\Session\Session');
        $session->shouldReceive('get')->with('Matthewbdaly\LaravelCart\Services\Cart')->once()->andReturn($data);
        $session->shouldReceive('put')->with('Matthewbdaly\LaravelCart\Services\Cart', $newdata)->once();
        $uniqid = m::mock('Matthewbdaly\LaravelCart\Contracts\Services\UniqueId');
        $cart = new Cart($session, $uniqid);
        $this->assertEquals(null, $cart->update('my_row_id_1', $newdata[0]));
    }

    /**
     * @dataProvider arrayProvider
     */
    public function testCanRemoveItem($data)
    {
        $data[0]['row_id'] = 'my_row_id_1';
        $data[1]['row_id'] = 'my_row_id_2';
        $session = m::mock('Illuminate\Contracts\Session\Session');
        $session->shouldReceive('get')->with('Matthewbdaly\LaravelCart\Services\Cart')->once()->andReturn($data);
        $session->shouldReceive('put')->with('Matthewbdaly\LaravelCart\Services\Cart', [$data[1]])->once();
        $uniqid = m::mock('Matthewbdaly\LaravelCart\Contracts\Services\UniqueId');
        $cart = new Cart($session, $uniqid);
        $this->assertEquals(null, $cart->remove('my_row_id_1'));
    }

    /**
     * @dataProvider arrayProvider
     */
    public function testCanDestroyCart($data)
    {
        $session = m::mock('Illuminate\Contracts\Session\Session');
        $session->shouldReceive('forget')->with('Matthewbdaly\LaravelCart\Services\Cart')->once()->andReturn([]);
        $uniqid = m::mock('Matthewbdaly\LaravelCart\Contracts\Services\UniqueId');
        $cart = new Cart($session, $uniqid);
        $this->assertEquals([], $cart->destroy());
    }

    /**
     * @dataProvider arrayProvider
     */
    public function testCanGetTotal($data)
    {
        $data[0]['row_id'] = 'my_row_id_1';
        $data[1]['row_id'] = 'my_row_id_2';
        $newdata = $data;
        $newdata[0]['qty'] = 2;
        $session = m::mock('Illuminate\Contracts\Session\Session');
        $session->shouldReceive('get')->with('Matthewbdaly\LaravelCart\Services\Cart')->once()->andReturn($data);
        $uniqid = m::mock('Matthewbdaly\LaravelCart\Contracts\Services\UniqueId');
        $cart = new Cart($session, $uniqid);
        $this->assertEquals((39.95 + (49.95 * 2)), $cart->total());
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
