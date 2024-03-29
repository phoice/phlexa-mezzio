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

namespace PhlexaMezzio\Intent;

use Interop\Container\ContainerInterface;
use Phlexa\Configuration\SkillConfiguration;
use Phlexa\Intent\AbstractIntent;
use Phlexa\Intent\IntentInterface;
use Phlexa\Request\AlexaRequest;
use Phlexa\Response\AlexaResponse;
use Phlexa\TextHelper\TextHelper;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class AbstractIntentFactory
 *
 * @package PhlexaMezzio\Intent
 */
class AbstractIntentFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return IntentInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var SkillConfiguration $skillConfiguration */
        $skillConfiguration = $container->get(SkillConfiguration::class);

        /** @var AlexaRequest $alexaRequest */
        $alexaRequest = $container->get(AlexaRequest::class);

        /** @var AlexaResponse $alexaResponse */
        $alexaResponse = $container->get(AlexaResponse::class);

        /** @var TextHelper $textHelper */
        $textHelper = $container->get($skillConfiguration->getTextHelperClass());

        /** @var AbstractIntent $intent */
        $intent = new $requestedName($alexaRequest, $alexaResponse, $textHelper, $skillConfiguration);

        $config = $container->get('config');

        $errorFlag = false;
        $errorPath = '';

        if (isset($config['phlexa'])) {
            if (isset($config['phlexa']['log_errors'])) {
                $errorFlag = $config['phlexa']['log_errors'];
            }
            if (isset($config['phlexa']['error_dir'])) {
                $errorPath = $config['phlexa']['error_dir'];
            }
        }
        $intent->setErrorLogFlag($errorFlag);
        $intent->setErrorPath($errorPath);

        return $intent;
    }
}
