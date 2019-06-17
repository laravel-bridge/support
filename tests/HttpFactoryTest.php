<?php

namespace Tests;

use Illuminate\Http\Request as IlluminateRequest;
use Illuminate\Http\Response as IlluminateResponse;
use LaravelBridge\Support\IlluminateHttpFactory;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpFoundation\Response;
use Zend\Diactoros\ServerRequest as Psr7Request;

class HttpFactoryTest extends TestCase
{
    /**
     * @var IlluminateHttpFactory
     */
    private $target;

    protected function setUp()
    {
        $this->target = new IlluminateHttpFactory();
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallCreateLaravelRequestWithLaravelRequest()
    {
        $actual = $this->target->createRequest(new IlluminateRequest(['foo' => 'bar']));

        $this->assertInstanceOf(IlluminateRequest::class, $actual);
        $this->assertSame('bar', $actual->query->get('foo'));
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallCreateLaravelRequestWithSymfonyRequest()
    {
        $actual = $this->target->createRequest(new SymfonyRequest(['foo' => 'bar']));

        $this->assertInstanceOf(IlluminateRequest::class, $actual);
        $this->assertSame('bar', $actual->query->get('foo'));
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallCreateLaravelRequestWithPsr7Request()
    {
        $request = (new Psr7Request())
            ->withQueryParams(['foo' => 'bar']);

        $actual = $this->target->createRequest($request);

        $this->assertInstanceOf(IlluminateRequest::class, $actual);
        $this->assertSame('bar', $actual->query->get('foo'));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function shouldThrowExceptionWhenCallCreateLaravelRequestWithUnknownInstance()
    {
        $this->target->createRequest(new stdClass());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallCreateLaravelResponseWithLaravelResponse()
    {
        $actual = $this->target->createResponse(new IlluminateResponse('foo'));

        $this->assertInstanceOf(IlluminateResponse::class, $actual);
        $this->assertSame('foo', $actual->getContent());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallCreateLaravelResponseWithSymfonyResponse()
    {
        $actual = $this->target->createResponse(new SymfonyResponse('foo'));

        $this->assertInstanceOf(IlluminateResponse::class, $actual);
        $this->assertSame('foo', $actual->getContent());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallCreateLaravelResponseWithPsr7Response()
    {
        $actual = $this->target->createResponse(new Response('foo'));

        $this->assertInstanceOf(IlluminateResponse::class, $actual);
        $this->assertSame('foo', $actual->getContent());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function shouldThrowExceptionWhenCallCreateLaravelResponseWithUnknownInstance()
    {
        $this->target->createResponse(new stdClass());
    }
}
