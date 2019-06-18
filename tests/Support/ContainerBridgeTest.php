<?php

namespace Tests\Support;

use Exception;
use Illuminate\Container\Container;
use LaravelBridge\Support\ContainerBridge;
use PHPUnit\Framework\TestCase;

class ContainerBridgeTest extends TestCase
{
    /**
     * @test
     */
    public function shouldImplementPsr11()
    {
        $target = new ContainerBridge(new Container());
        $target->instance('config', 'whatever');

        $this->assertTrue($target->has('config'));
        $this->assertSame('whatever', $target->get('config'));
    }

    /**
     * @test
     * @expectedException \LaravelBridge\Support\Exceptions\EntryNotFoundException
     */
    public function shouldThrowExceptionWhenEntryNotFound()
    {
        $target = new ContainerBridge(new Container());

        $target->get('config');
    }

    /**
     * @test
     * @expectedException \BadMethodCallException
     */
    public function shouldThrowExceptionWhenCallNotExistMethod()
    {
        $target = new ContainerBridge(new Container());

        $target->badMethodCall();
    }

    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage custom exception
     */
    public function shouldThrowCustomExceptionWhenExceptionIsThrowFromConcreteInContainer()
    {
        $target = new ContainerBridge(new Container());
        $target->singleton('config', function () {
            throw new Exception('custom exception');
        });

        $target->get('config');
    }

    /**
     * @test
     */
    public function shouldImplementArrayAccess()
    {
        $target = new ContainerBridge(new Container());
        $target['config'] = 'whatever';

        $this->assertTrue(isset($target['config']));
        $this->assertSame('whatever', $target['config']);

        unset($target['config']);

        $this->assertFalse(isset($target['config']));
    }

    /**
     * @test
     */
    public function shouldImplementMagicMethod()
    {
        $target = new ContainerBridge(new Container());
        $target->config = 'whatever';

        $this->assertTrue(isset($target->config));
        $this->assertSame('whatever', $target['config']);
    }
}
