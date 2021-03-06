<?php

/**
 * This file is part of the SKTwigExtensionsBundle package.
 *
 * (c) Sebastian Kroczek <sk@xbug.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SK\TwigExtensionsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class SKTwigExtensionsExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yml');

        $enableFormatExtension = false;
        $enableUtilExtension = false;
        $enableRoutingExtraExtension = false;

        foreach ($config['extensions'] as $key => $value) {
            if ('format_extension' === $key) {
                $enableFormatExtension = $value;
            } elseif ('util_extension' === $key) {
                $enableUtilExtension = $value;
            } elseif ('routing_extra_extension' === $key) {
                $enableRoutingExtraExtension = $value;
            } elseif ('string_extension' === $key) {
                $enableStringExtension = $value;
            }
        }

        if ($enableFormatExtension) {
            $container->register(
                'sk.format.twig_extension',
                'SK\TwigExtensionsBundle\Twig\FormatTwigExtension'
            )
                ->setPublic(true)
                ->addTag('twig.extension');
        }

        if ($enableRoutingExtraExtension) {
            $container->register(
                'sk.routing_extra.twig_extension',
                'SK\TwigExtensionsBundle\Twig\RoutingExtraTwigExtension'
            )
                ->addArgument(new Reference('router'))
                ->setPublic(true)
                ->addTag('twig.extension');
        }

        if ($enableUtilExtension) {
            $container->register(
                'sk.util.twig_extension',
                'SK\TwigExtensionsBundle\Twig\UtilTwigExtension'
            )
                ->setPublic(true)
                ->addTag('twig.extension');
        }

        if ($enableStringExtension) {
            $container->register(
                'sk.string.twig_extension',
                'SK\TwigExtensionsBundle\Twig\StringTwigExtension'
            )
                ->setPublic(true)
                ->addTag('twig.extension');
        }
    }
}
