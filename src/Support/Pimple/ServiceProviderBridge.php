<?php

declare(strict_types=1);

namespace LaravelBridge\Support\Pimple;

use LaravelBridge\Support\Traits\ContainerAwareTrait;
use Pimple\ServiceProviderInterface;
use Psr\Container\ContainerInterface;

class ServiceProviderBridge
{
    use ContainerAwareTrait;

    /**
     * @param ContainerInterface $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function register(ServiceProviderInterface $provider): ServiceProviderBridge
    {
        $pimpleSpy = new ContainerSpy();
        $pimpleSpy->setContainer($this->container);

        $provider->register($pimpleSpy);

        return $this;
    }
}
