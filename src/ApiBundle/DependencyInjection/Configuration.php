<?php

namespace ApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('api');

        $root->children()
                    ->scalarNode('radius')
                        ->info('Default distance in kilometers to look for pubs around given coordinates')
                        ->defaultValue(1)
                    ->end()
                    ->integerNode('cache_lifetime')
                        ->defaultValue(10)
                    ->end()

                    ->arrayNode('point')
                        ->isRequired()
                        ->info('Coordinates from which nearest pubs should be taken')
                        ->children()
                            ->floatNode('latitude')->isRequired()->end()
                            ->floatNode('longitude')->isRequired()->end()
                        ->end()
                    ->end()
                ->end()
            ;

        return $treeBuilder;
    }
}
