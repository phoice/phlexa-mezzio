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

namespace PhlexaMezzio\Handler;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Router\RouteResult;
use Mezzio\Template\TemplateRendererInterface;

/**
 * Class HtmlPageHandler
 *
 * @package PhlexaMezzio\Handler
 */
class HtmlPageHandler implements RequestHandlerInterface
{
    /** @var  TemplateRendererInterface */
    private $template;

    /**
     * HtmlPageHandler constructor.
     *
     * @param TemplateRendererInterface $template
     */
    public function __construct(TemplateRendererInterface $template)
    {
        $this->template = $template;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     * @throws InvalidArgumentException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var RouteResult $routeResult */
        $routeResult = $request->getAttribute(RouteResult::class);

        $template = $routeResult->getMatchedParams()['template'];

        return new HtmlResponse(
            $this->template->render($template, [])
        );
    }
}
