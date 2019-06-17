<?php

namespace Tests\Support\Pimple;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class FixtureServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['bar'] = function ($c) {

            return 'bar' . $c['foo'];
        };
    }
}
