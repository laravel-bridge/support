<?php

namespace LaravelBridge\Support\Pimple;

use LaravelBridge\Support\Traits\ContainerAwareTrait;
use Pimple\Container as PimpleContainer;

class ContainerSpy extends PimpleContainer
{
    use ContainerAwareTrait;

    /**
     * @param string $id
     * @param mixed $value
     */
    public function offsetSet($id, $value)
    {
        $this->container->offsetSet($id, $value);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function offsetGet($id)
    {
        return $this->container->offsetGet($id);
    }

    /**
     * @return bool
     */
    public function offsetExists($id)
    {
        return $this->container->offsetExists($id);
    }

    /**
     * @param string $id
     */
    public function offsetUnset($id)
    {
        $this->container->offsetUnset($id);
    }
}
