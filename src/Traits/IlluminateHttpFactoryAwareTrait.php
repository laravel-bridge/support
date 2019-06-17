<?php

namespace LaravelBridge\Support\Traits;

use LaravelBridge\Support\IlluminateHttpFactory;

trait IlluminateHttpFactoryAwareTrait
{
    /**
     * @var IlluminateHttpFactory
     */
    protected $illuminateHttpFactory;

    /**
     * @return IlluminateHttpFactory
     */
    public function getIlluminateHttpFactory()
    {
        if (null === $this->illuminateHttpFactory) {
            $this->illuminateHttpFactory = new IlluminateHttpFactory();
        }

        return $this->illuminateHttpFactory;
    }

    /**
     * @param IlluminateHttpFactory $illuminateHttpFactory
     * @return static
     */
    public function setIlluminateHttpFactory($illuminateHttpFactory)
    {
        $this->illuminateHttpFactory = $illuminateHttpFactory;

        return $this;
    }
}
