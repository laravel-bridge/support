<?php

namespace LaravelBridge\Support;

use Illuminate\Http\Request as LaravelRequest;
use Illuminate\Http\Response as LaravelResponse;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface as Psr7Response;
use Psr\Http\Message\ServerRequestInterface as Psr7Request;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class HttpTransformer
{
    /**
     * @param mixed $request
     * @return LaravelRequest
     */
    public function createLaravelRequest($request)
    {
        if ($request instanceof LaravelRequest) {
            return $request;
        }

        if ($request instanceof Psr7Request) {
            $request = (new HttpFoundationFactory)->createRequest($request);
        }

        if ($request instanceof SymfonyRequest) {
            return LaravelRequest::createFromBase($request);
        }

        throw new InvalidArgumentException('Unknown request type');
    }

    /**
     * @param mixed $response
     * @return LaravelResponse
     */
    public function createLaravelResponse($response)
    {
        if ($response instanceof LaravelResponse) {
            return $response;
        }

        if ($response instanceof Psr7Response) {
            $response = (new HttpFoundationFactory)->createResponse($response);
        }

        if ($response instanceof SymfonyResponse) {
            return new LaravelResponse(
                $response->getContent(),
                $response->getStatusCode(),
                $response->headers->all()
            );
        }

        throw new InvalidArgumentException('Unknown response type');
    }
}
