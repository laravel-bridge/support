<?php

namespace Tests;

use Illuminate\Http\Request as LaravelRequest;
use Illuminate\Http\Response as LaravelResponse;
use LaravelBridge\Support\HttpTransformer;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpFoundation\Response;
use Zend\Diactoros\ServerRequest as Psr7Request;

class HttpTransformerTest extends TestCase
{
    /**
     * @var HttpTransformer
     */
    private $target;

    protected function setUp()
    {
        $this->target = new HttpTransformer;
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallCreateLaravelRequestWithLaravelRequest()
    {
        $actual = $this->target->createLaravelRequest(new LaravelRequest(['foo' => 'bar']));

        $this->assertInstanceOf(LaravelRequest::class, $actual);
        $this->assertSame('bar', $actual->query->get('foo'));
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallCreateLaravelRequestWithSymfonyRequest()
    {
        $actual = $this->target->createLaravelRequest(new SymfonyRequest(['foo' => 'bar']));

        $this->assertInstanceOf(LaravelRequest::class, $actual);
        $this->assertSame('bar', $actual->query->get('foo'));
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallCreateLaravelRequestWithPsr7Request()
    {
        $request = (new Psr7Request())
            ->withQueryParams(['foo' => 'bar']);

        $actual = $this->target->createLaravelRequest($request);

        $this->assertInstanceOf(LaravelRequest::class, $actual);
        $this->assertSame('bar', $actual->query->get('foo'));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function shouldThrowExceptionWhenCallCreateLaravelRequestWithUnknownInstance()
    {
        $this->target->createLaravelRequest(new stdClass());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallCreateLaravelResponseWithLaravelResponse()
    {
        $actual = $this->target->createLaravelResponse(new LaravelResponse('foo'));

        $this->assertInstanceOf(LaravelResponse::class, $actual);
        $this->assertSame('foo', $actual->getContent());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallCreateLaravelResponseWithSymfonyResponse()
    {
        $actual = $this->target->createLaravelResponse(new SymfonyResponse('foo'));

        $this->assertInstanceOf(LaravelResponse::class, $actual);
        $this->assertSame('foo', $actual->getContent());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallCreateLaravelResponseWithPsr7Response()
    {
        $actual = $this->target->createLaravelResponse(new Response('foo'));

        $this->assertInstanceOf(LaravelResponse::class, $actual);
        $this->assertSame('foo', $actual->getContent());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function shouldThrowExceptionWhenCallCreateLaravelResponseWithUnknownInstance()
    {
        $this->target->createLaravelResponse(new stdClass());
    }
}
