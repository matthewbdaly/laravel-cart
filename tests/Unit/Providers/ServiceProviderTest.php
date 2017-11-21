<?php

namespace Tests\Unit\Providers;

use Tests\TestCase;
use Mockery as m;
use Cart;

class ServiceProviderTest extends TestCase
{
    public function testSetupCart()
    {
        $cart = $this->app->make('Matthewbdaly\LaravelCart\Contracts\Services\Cart');
        $this->assertInstanceOf(\Matthewbdaly\LaravelCart\Services\Cart::class, $cart);
    }

    public function testSetupUniqueId()
    {
        $cart = $this->app->make('Matthewbdaly\LaravelCart\Contracts\Services\UniqueId');
        $this->assertInstanceOf(\Matthewbdaly\LaravelCart\Services\UniqueId::class, $cart);
    }

    public function testFacade()
    {
        $mock = m::mock('Matthewbdaly\LaravelCart\Contracts\Services\Cart');
        $mock->shouldReceive('destroy')->once();
        $this->app->instance('Matthewbdaly\LaravelCart\Contracts\Services\Cart', $mock);
        $this->assertInstanceOf('Matthewbdaly\LaravelCart\Contracts\Services\Cart', $this->app['Matthewbdaly\LaravelCart\Contracts\Services\Cart']);
        Cart::destroy();
    }
}
