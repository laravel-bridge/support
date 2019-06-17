<?php

namespace LaravelBridge\Support;

use BadMethodCallException;
use Exception;
use Illuminate\Container\Container;
use LaravelBridge\Support\Exceptions\EntryNotFoundException;
use Psr\Container\ContainerInterface;

/**
 * Bridge Laravel Container to PSR-11 Container
 *
 * When Laravel <= 5.4, it does not implements Psr7Container. We can use this class to bridge to PSR-11 Container
 *
 * @mixin Container
 */
class ContainerBridge implements ContainerInterface
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __call($method, $arguments)
    {
        if (method_exists($this->container, $method)) {
            return call_user_func_array([$this->container, $method], $arguments);
        }

        throw new BadMethodCallException("Undefined method '$method'");
    }

    /**
     *  {@inheritdoc}
     */
    public function get($id)
    {
        try {
            return $this->container->make($id);
        } catch (Exception $e) {
            if ($this->has($id)) {
                throw $e;
            }

            throw new EntryNotFoundException("Entry '$id' is not found");
        }
    }

    /**
     *  {@inheritdoc}
     */
    public function has($id)
    {
        return $this->container->bound($id);
    }
}
