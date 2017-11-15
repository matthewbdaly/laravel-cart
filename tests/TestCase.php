<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Mockery as m;

class TestCase extends BaseTestCase
{
	protected function getPackageProviders($app)
	{
		return ['Matthewbdaly\LaravelCart\Providers\CartServiceProvider'];
    }

    public function tearDown()
    {
        m::close();
        parent::tearDown();
    }
}
