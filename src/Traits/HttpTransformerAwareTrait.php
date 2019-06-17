<?php

namespace LaravelBridge\Support\Traits;

use LaravelBridge\Support\HttpTransformer;

trait HttpTransformerAwareTrait
{
    /**
     * @var HttpTransformer
     */
    protected $httpTransformer;

    /**
     * @return HttpTransformer
     */
    public function getHttpTransformer()
    {
        if (null === $this->httpTransformer) {
            $this->httpTransformer = new HttpTransformer();
        }

        return $this->httpTransformer;
    }

    /**
     * @param HttpTransformer $httpTransformer
     * @return static
     */
    public function setHttpTransformer($httpTransformer)
    {
        $this->httpTransformer = $httpTransformer;

        return $this;
    }
}
