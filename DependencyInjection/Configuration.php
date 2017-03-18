<?php

/*
 * This file is part of the SKTwigExtensionsBundle package.
 *
 * (c) Sebastian Kroczek <sk@xbug.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SK\TwigExtensionsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sk_twig_extensions');
        $rootNode
                ->append($this->getExtensionsNode())
            ->end();

        return $treeBuilder;
    }

    private function getExtensionsNode()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('extensions');
        $node
            ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('format_extension')->cannotBeEmpty()->defaultFalse()->end()
                    ->scalarNode('routing_extra_extension')->cannotBeEmpty()->defaultFalse()->end()
                    ->scalarNode('util_extension')->cannotBeEmpty()->defaultFalse()->end()
                    ->scalarNode('string_extension')->cannotBeEmpty()->defaultFalse()->end()
                ->end()

            ->end()
        ;

        return $node;
    }
}
