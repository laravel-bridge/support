<?php

declare(strict_types=1);

namespace LaravelBridge\Support\Traits;

use Closure;
use Psr\Container\ContainerInterface;

trait ContainerAwareTrait
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param ContainerInterface $container
     * @return static
     */
    public function setContainer($container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @param mixed $concrete
     * @return Closure
     */
    protected function getConcreteClosure($concrete)
    {
        return $concrete instanceof Closure ? $concrete : function () use ($concrete) {
            return $concrete;
        };
    }
}
