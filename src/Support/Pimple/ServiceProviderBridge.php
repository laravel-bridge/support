<?php

declare(strict_types=1);

namespace LaravelBridge\Support\Pimple;

use Illuminate\Contracts\Container\Container;
use LaravelBridge\Support\Traits\ContainerAwareTrait;
use Pimple\Container as PimpleContainer;
use Pimple\ServiceProviderInterface;

class ServiceProviderBridge
{
    use ContainerAwareTrait;

    /**
     * @param Container $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function register(ServiceProviderInterface $provider)
    {
        $pimpleSpy = new ContainerSpy();
        $pimpleSpy->setContainer($this->container);

        $provider->register($pimpleSpy);
    }
}
