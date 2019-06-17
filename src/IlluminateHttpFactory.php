<?php

namespace LaravelBridge\Support;

use Illuminate\Http\Request as IlluminateRequest;
use Illuminate\Http\Response as IlluminateResponse;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface as Psr7Response;
use Psr\Http\Message\ServerRequestInterface as Psr7Request;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class IlluminateHttpFactory
{
    /**
     * @param mixed $request
     * @return IlluminateRequest
     */
    public function createRequest($request)
    {
        if ($request instanceof IlluminateRequest) {
            return $request;
        }

        if ($request instanceof Psr7Request) {
            $request = (new HttpFoundationFactory)->createRequest($request);
        }

        if ($request instanceof SymfonyRequest) {
            return IlluminateRequest::createFromBase($request);
        }

        throw new InvalidArgumentException('Unknown request type');
    }

    /**
     * @param mixed $response
     * @return IlluminateResponse
     */
    public function createResponse($response)
    {
        if ($response instanceof IlluminateResponse) {
            return $response;
        }

        if ($response instanceof Psr7Response) {
            $response = (new HttpFoundationFactory)->createResponse($response);
        }

        if ($response instanceof SymfonyResponse) {
            return new IlluminateResponse(
                $response->getContent(),
                $response->getStatusCode(),
                $response->headers->all()
            );
        }

        throw new InvalidArgumentException('Unknown response type');
    }
}
