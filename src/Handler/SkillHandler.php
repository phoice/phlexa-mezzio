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

use Exception;
use InvalidArgumentException;
use Phlexa\Application\AlexaApplicationInterface;
use Phlexa\Request\Exception\BadRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;

/**
 * Class SkillHandler
 *
 * @package PhlexaMezzio\Handler
 */
class SkillHandler implements RequestHandlerInterface
{
    /** @var AlexaApplicationInterface */
    private $alexaApplication;

    /**
     * SkillHandler constructor.
     *
     * @param AlexaApplicationInterface $alexaApplication
     */
    public function __construct(AlexaApplicationInterface $alexaApplication)
    {
        $this->alexaApplication = $alexaApplication;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     * @throws InvalidArgumentException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $data = $this->alexaApplication->execute();

            return new JsonResponse($data, 200);
        } catch (BadRequest $e) {
            $data = ['error' => $e->getMessage()];

            return new JsonResponse($data, 400);
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];

            return new JsonResponse($data, 400);
        }
    }
}
