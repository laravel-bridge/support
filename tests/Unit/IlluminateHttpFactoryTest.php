<?php

namespace Tests\Unit;

use Illuminate\Http\Request as IlluminateRequest;
use Illuminate\Http\Response as IlluminateResponse;
use InvalidArgumentException;
use Laminas\Diactoros\ServerRequest as Psr7Request;
use LaravelBridge\Support\IlluminateHttpFactory;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class IlluminateHttpFactoryTest extends TestCase
{
    /**
     * @var IlluminateHttpFactory
     */
    private $target;

    protected function setUp(): void
    {
        $this->target = new IlluminateHttpFactory();
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallCreateLaravelRequestWithLaravelRequest(): void
    {
        $actual = $this->target->createRequest(new IlluminateRequest(['foo' => 'bar']));

        $this->assertInstanceOf(IlluminateRequest::class, $actual);
        $this->assertSame('bar', $actual->query->get('foo'));
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallCreateLaravelRequestWithSymfonyRequest(): void
    {
        $actual = $this->target->createRequest(new SymfonyRequest(['foo' => 'bar']));

        $this->assertInstanceOf(IlluminateRequest::class, $actual);
        $this->assertSame('bar', $actual->query->get('foo'));
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallCreateLaravelRequestWithPsr7Request(): void
    {
        $request = (new Psr7Request())
            ->withQueryParams(['foo' => 'bar']);

        $actual = $this->target->createRequest($request);

        $this->assertInstanceOf(IlluminateRequest::class, $actual);
        $this->assertSame('bar', $actual->query->get('foo'));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenCallCreateLaravelRequestWithUnknownInstance(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->target->createRequest(new stdClass());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallCreateLaravelResponseWithLaravelResponse(): void
    {
        $actual = $this->target->createResponse(new IlluminateResponse('foo'));

        $this->assertInstanceOf(IlluminateResponse::class, $actual);
        $this->assertSame('foo', $actual->getContent());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallCreateLaravelResponseWithSymfonyResponse(): void
    {
        $actual = $this->target->createResponse(new SymfonyResponse('foo'));

        $this->assertInstanceOf(IlluminateResponse::class, $actual);
        $this->assertSame('foo', $actual->getContent());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallCreateLaravelResponseWithPsr7Response(): void
    {
        $actual = $this->target->createResponse(new SymfonyResponse('foo'));

        $this->assertInstanceOf(IlluminateResponse::class, $actual);
        $this->assertSame('foo', $actual->getContent());
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenCallCreateLaravelResponseWithUnknownInstance(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->target->createResponse(new stdClass());
    }
}
