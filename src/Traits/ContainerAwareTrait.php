<?php

namespace LaravelBridge\Support\Traits;

use Illuminate\Contracts\Container\Container;

trait ContainerAwareTrait
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param Container $container
     * @return static
     */
    public function setContainer($container)
    {
        $this->container = $container;

        return $this;
    }
}
