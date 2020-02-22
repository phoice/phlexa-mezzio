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

namespace PhlexaMezzio\TextHelper;

use Interop\Container\ContainerInterface;
use Phlexa\Configuration\SkillConfiguration;
use Phlexa\Configuration\SkillConfigurationInterface;
use Phlexa\TextHelper\TextHelper;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class TextHelperFactory
 *
 * @package PhlexaMezzio\TextHelper
 */
class TextHelperFactory implements FactoryInterface
{
    /**
     * @var string
     */
    protected $configKey = null;

    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return TextHelper
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var SkillConfigurationInterface $skillConfiguration */
        $skillConfiguration = $container->get(SkillConfiguration::class);

        $texts = $skillConfiguration->getTexts();

        return new $requestedName($texts);
    }
}
