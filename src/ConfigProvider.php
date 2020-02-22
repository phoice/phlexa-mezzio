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

namespace PhlexaMezzio;

use Phlexa\Application\AlexaApplication;
use Phlexa\Configuration\SkillConfiguration;
use Phlexa\Request\AlexaRequest;
use Phlexa\Request\Certificate\CertificateLoader;
use Phlexa\Request\Certificate\CertificateValidator;
use Phlexa\Response\AlexaResponse;
use Phlexa\Session\SessionContainer;
use Phlexa\TextHelper\TextHelper;
use PhlexaMezzio\Handler\HtmlPageHandler;
use PhlexaMezzio\Handler\HtmlPageHandlerFactory;
use PhlexaMezzio\Handler\SkillHandler;
use PhlexaMezzio\Handler\SkillHandlerFactory;
use PhlexaMezzio\Application\AlexaApplicationFactory;
use PhlexaMezzio\Intent\IntentManager;
use PhlexaMezzio\Intent\IntentManagerFactory;
use PhlexaMezzio\Middleware\CheckApplicationMiddleware;
use PhlexaMezzio\Middleware\CheckApplicationMiddlewareFactory;
use PhlexaMezzio\Middleware\ConfigureSkillMiddleware;
use PhlexaMezzio\Middleware\ConfigureSkillMiddlewareFactory;
use PhlexaMezzio\Middleware\LogAlexaRequestMiddleware;
use PhlexaMezzio\Middleware\LogAlexaRequestMiddlewareFactory;
use PhlexaMezzio\Middleware\SetLocaleMiddleware;
use PhlexaMezzio\Middleware\SetLocaleMiddlewareFactory;
use PhlexaMezzio\Middleware\ValidateCertificateMiddleware;
use PhlexaMezzio\Middleware\ValidateCertificateMiddlewareFactory;
use PhlexaMezzio\Request\AlexaRequestFactory;
use PhlexaMezzio\Request\Certificate\CertificateLoaderFactory;
use PhlexaMezzio\Request\Certificate\CertificateValidatorFactory;
use PhlexaMezzio\Response\AlexaResponseFactory;
use PhlexaMezzio\Session\SessionContainerFactory;
use PhlexaMezzio\TextHelper\TextHelperFactory;
use Laminas\ServiceManager\Factory\InvokableFactory;

/**
 * Class ConfigProvider
 *
 * @package Phlexa
 */
class ConfigProvider
{
    /**
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                'factories' => [
                    HtmlPageHandler::class => HtmlPageHandlerFactory::class,
                    SkillHandler::class    => SkillHandlerFactory::class,

                    AlexaApplication::class => AlexaApplicationFactory::class,
                    AlexaRequest::class     => AlexaRequestFactory::class,
                    AlexaResponse::class    => AlexaResponseFactory::class,

                    SessionContainer::class   => SessionContainerFactory::class,
                    SkillConfiguration::class => InvokableFactory::class,
                    TextHelper::class         => TextHelperFactory::class,
                    IntentManager::class      => IntentManagerFactory::class,

                    CertificateLoader::class    => CertificateLoaderFactory::class,
                    CertificateValidator::class => CertificateValidatorFactory::class,

                    CheckApplicationMiddleware::class    => CheckApplicationMiddlewareFactory::class,
                    ConfigureSkillMiddleware::class      => ConfigureSkillMiddlewareFactory::class,
                    LogAlexaRequestMiddleware::class     => LogAlexaRequestMiddlewareFactory::class,
                    SetLocaleMiddleware::class           => SetLocaleMiddlewareFactory::class,
                    ValidateCertificateMiddleware::class => ValidateCertificateMiddlewareFactory::class,
                ],
            ],
        ];
    }
}
