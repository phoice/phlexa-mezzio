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

namespace PhlexaMezzio\Application;

use Interop\Container\ContainerInterface;
use Phlexa\Application\AlexaApplication;
use Phlexa\Request\AlexaRequest;
use Phlexa\Response\AlexaResponse;
use PhlexaMezzio\Intent\IntentManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class AlexaApplicationFactory
 *
 * @package PhlexaMezzio\Application
 */
class AlexaApplicationFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null|null    $options
     *
     * @return AlexaApplication
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ): AlexaApplication {
        $alexaRequest  = $container->get(AlexaRequest::class);
        $alexaResponse = $container->get(AlexaResponse::class);
        $intentManager = $container->get(IntentManager::class);

        /** @var AlexaApplication $alexaApplication */
        $alexaApplication = new $requestedName(
            $alexaRequest,
            $alexaResponse,
            $intentManager
        );

        return $alexaApplication;
    }
}
