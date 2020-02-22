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

namespace PhlexaMezzio\Request;

use Exception;
use Interop\Container\ContainerInterface;
use Phlexa\Request\AlexaRequest;
use Phlexa\Request\RequestType\RequestTypeFactory;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class AlexaRequestFactory
 *
 * @package PhlexaMezzio\Request
 */
class AlexaRequestFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return AlexaRequest
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $serverRequest = ServerRequestFactory::fromGlobals();

        if (empty($serverRequest->getBody()->getContents())) {
            return null;
        }

        if (!$this->isJson($serverRequest->getBody()->getContents())) {
            return null;
        }

        /** @var AlexaRequest $alexaRequest */
        $alexaRequest = RequestTypeFactory::createFromData(
            $serverRequest->getBody()->getContents()
        );

        return $alexaRequest;
    }

    /**
     * @param $string
     *
     * @return bool
     */
    private function isJson($string)
    {
        json_decode($string);

        return (json_last_error() == JSON_ERROR_NONE);
    }
}
