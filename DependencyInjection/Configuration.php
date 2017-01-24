<?php


namespace Artgris\Bundle\InteractiveSVGBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Arthur Gribet <a.gribet@gmail.com>
 */
class Configuration implements ConfigurationInterface
{

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('artgris_interactive_svg');

        $rootNode
            ->children()
            ->scalarNode('svg_dir')->defaultValue('%kernel.root_dir%/../web/svg')->end()
            ->end();
        return $treeBuilder;
    }
}
