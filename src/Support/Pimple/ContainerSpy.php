<?php

declare(strict_types=1);

namespace LaravelBridge\Support\Pimple;

use ArrayAccess;
use DI\Container as PHPDIContainer;
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
        if ($this->container instanceof ArrayAccess) {
            $this->container->offsetSet($id, $value);
        } elseif ($this->container instanceof PHPDIContainer) {
            $this->container->set($id, $value);
        }

        $this->container['id'] = $value;
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function offsetGet($id)
    {
        if ($this->container instanceof ArrayAccess) {
            return $this->container->offsetGet($id);
        } elseif ($this->container instanceof PHPDIContainer) {
            return $this->container->get($id);
        }

        return $this->container->offsetGet($id);
    }

    /**
     * @return bool
     */
    public function offsetExists($id)
    {
        if ($this->container instanceof ArrayAccess) {
            return $this->container->offsetExists($id);
        } elseif ($this->container instanceof PHPDIContainer) {
            return $this->container->has($id);
        }

        return isset($this->container['id']);
    }

    /**
     * @param string $id
     */
    public function offsetUnset($id)
    {
        if ($this->container instanceof ArrayAccess) {
            $this->container->offsetUnset($id);
        }

        unset($this->container[$id]);
    }
}
