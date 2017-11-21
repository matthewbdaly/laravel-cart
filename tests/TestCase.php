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

	protected function getPackageAliases($app)
	{
		return [
			'Cart' => 'Matthewbdaly\LaravelCart\Facade'
		];
	}

    public function tearDown()
    {
        m::close();
        parent::tearDown();
    }
}
