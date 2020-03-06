<?php

namespace Tests\Support\Pimple;

use Illuminate\Container\Container;
use LaravelBridge\Support\Pimple\ServiceProviderBridge;
use PHPUnit\Framework\TestCase;

class ServiceProviderBridgeTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeOkayRegisterUsingPimpleServiceProvider(): void
    {
        $actual = new Container();
        $actual['foo'] = 'baz';

        $target = new ServiceProviderBridge($actual);
        $target->register(new FixtureServiceProvider());

        $this->assertSame('baz', $actual->make('foo'));
        $this->assertSame('barbaz', $actual->make('bar'));
    }
}
