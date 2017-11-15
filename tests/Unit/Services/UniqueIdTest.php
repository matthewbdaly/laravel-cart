<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Mockery as m;

class UniqueIdTest extends TestCase
{
    public function testCreateUniqueId()
    {
        $instance = $this->app->make('Matthewbdaly\LaravelCart\Contracts\Services\UniqueId');
        $this->assertInstanceOf('Matthewbdaly\LaravelCart\Services\UniqueId', $instance);
        $this->assertTrue(is_string($instance->get()));
    }
}
