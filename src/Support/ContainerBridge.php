<?php

namespace LaravelBridge\Support;

use ArrayAccess;
use BadMethodCallException;
use Exception;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\Container as ContainerContract;
use LaravelBridge\Support\Exceptions\EntryNotFoundException;
use LaravelBridge\Support\Traits\ContainerAwareTrait;
use Psr\Container\ContainerInterface;

/**
 * Bridge Laravel Container to PSR-11 Container
 *
 * When Laravel <= 5.4, it does not implements Psr7Container. We can use this class to bridge to PSR-11 Container
 *
 * @mixin Container
 */
class ContainerBridge implements ArrayAccess, ContainerInterface
{
    use ContainerAwareTrait;

    /**
     * @param ContainerContract $container
     */
    public function __construct(ContainerContract $container = null)
    {
        if (null === $container) {
            $container = new Container();
        }

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

    /**
     * Proxy to Container offsetExists()
     *
     * @param string $key
     * @return bool
     * @see Container::offsetExists()
     */
    public function offsetExists($key)
    {
        return $this->container->offsetExists($key);
    }

    /**
     * Proxy to Container offsetGet()
     *
     * @param string $key
     * @return mixed
     * @see Container::offsetGet()
     */
    public function offsetGet($key)
    {
        return $this->container->offsetGet($key);
    }

    /**
     * Proxy to Container offsetSet()
     *
     * @param string $key
     * @param mixed $value
     * @see Container::offsetSet()
     */
    public function offsetSet($key, $value)
    {
        $this->container->offsetSet($key, $value);
    }

    /**
     * Proxy to Container offsetUnset()
     *
     * @param string $key
     * @see Container::offsetUnset()
     */
    public function offsetUnset($key)
    {
        $this->container->offsetUnset($key);
    }

    /**
     * Proxy to Container __get()
     *
     * @param string $key
     * @return mixed
     * @see Container::__get()
     */
    public function __get($key)
    {
        return $this->container->__get($key);
    }

    /**
     * Proxy to Container __set()
     *
     * @param string $key
     * @param mixed $value
     * @see Container::__set()
     */
    public function __set($key, $value)
    {
        $this->container->__set($key, $value);
    }

    /**
     * Proxy to Container __isset()
     *
     * @param string $key
     * @return bool
     * @see Container::__isset()
     */
    public function __isset($key)
    {
        return $this->container->offsetExists($key);
    }
}
