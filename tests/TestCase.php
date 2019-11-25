<?php

namespace LimeDeck\NovaCashierOverview\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use LimeDeck\NovaCashierOverview\Providers\CashierOverviewServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            CashierOverviewServiceProvider::class,
        ];
    }
}
