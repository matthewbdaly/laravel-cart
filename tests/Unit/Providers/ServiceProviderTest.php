<?php

namespace Tests\Unit\Providers;

use Tests\TestCase;

class ServiceProviderTest extends TestCase
{
    /** @test */
    public function it_sets_up_the_repository()
    {
        $cart = $this->app->make('Matthewbdaly\LaravelCart\Contracts\Services\Cart');
        $this->assertInstanceOf(\Matthewbdaly\LaravelCart\Services\Cart::class, $cart);
    }
}
