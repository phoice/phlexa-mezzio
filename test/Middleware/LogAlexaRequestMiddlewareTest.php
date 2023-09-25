<?php
/**
 * Build voice applications for Amazon Alexa with phlexa, PHP and Mezzio
 *
 * @author     Ralf Eggert <ralf@travello.audio>
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/phoice/phlexa-mezzio
 * @link       https://www.phoice.tech/
 * @link       https://www.travello.audio/
 */

declare(strict_types=1);

namespace PhlexaMezzioTest\Middleware;

use Fig\Http\Message\RequestMethodInterface;
use PhlexaMezzio\Middleware\LogAlexaRequestMiddleware;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class LogAlexaRequestMiddlewareTest
 *
 * @package PhlexaMezzioTest\Middleware
 */
class LogAlexaRequestMiddlewareTest extends TestCase
{
    /**
     *
     */
    public function testWithGetRequest(): void
    {
        /** @var ServerRequestInterface|MockObject $request */
        $request = $this->createMock(ServerRequestInterface::class);

        $request->expects($this->once())
        ->method('getMethod')
        ->willReturn(
            RequestMethodInterface::METHOD_GET
        );

        /** @var ResponseInterface|MockObject $response */
        $response = $this->createMock(ResponseInterface::class);

        /** @var RequestHandlerInterface|ObjectProphecy $handler */
        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->expects($this->any())->method('handle')->with($request)->willReturn($response);

        $middleware = new LogAlexaRequestMiddleware();

        $result = $middleware->process($request, $handler);

        $this->assertSame($response, $result);
    }

    /**
     *
     */
    public function testWithPostRequest(): void
    {
        $data = [
            'version' => '1.0',
            'session' => [
                'new'         => true,
                'sessionId'   => 'sessionId',
                'application' => [
                    'applicationId' => 'applicationId',
                ],
                'user'        => [
                    'userId' => 'userId',
                ],
            ],
            'request' => [
                'type'      => 'LaunchRequest',
                'requestId' => 'requestId',
                'timestamp' => '2017-01-27T20:29:59Z',
                'locale'    => 'de-DE',
            ],
        ];

        /** @var ServerRequestInterface|MockObject $request */
        $request = $this->createMock(ServerRequestInterface::class);

        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn(
                RequestMethodInterface::METHOD_POST
            );

        $request->expects($this->any())
            ->method('getHeaderLine')
            ->with('signaturecertchainurl')
            ->willReturn(['foo']);

        /** @var ResponseInterface|MockObject $response */
        $response = $this->createMock(ResponseInterface::class);

        /** @var RequestHandlerInterface|MockObject $handler */
        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->expects($this->any())
            ->method('handle')->with($request)->willReturn($response);

        $middleware = new LogAlexaRequestMiddleware();

        $result = $middleware->process($request, $handler);

        $this->assertEquals($response, $result);
    }
}
