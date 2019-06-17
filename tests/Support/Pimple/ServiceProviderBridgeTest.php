<?php

namespace Tests\Support\Pimple;

use Exception;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;
use LaravelBridge\Support\ContainerBridge;
use LaravelBridge\Support\Pimple\ServiceProviderBridge;
use PHPUnit\Framework\TestCase;
use Pimple\ServiceProviderInterface;

class ServiceProviderBridgeTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeOkayRegisterUsingPimpleServiceProvider()
    {
        $actual = new Container();
        $actual['foo'] = 'baz';

        $target = new ServiceProviderBridge($actual);
        $target->register(new FixtureServiceProvider());

        $this->assertSame('baz', $actual->make('foo'));
        $this->assertSame('barbaz', $actual->make('bar'));
    }
}
