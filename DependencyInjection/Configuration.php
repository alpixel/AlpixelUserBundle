<?php

namespace Alpixel\Bundle\UserBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('alpixel_user');

        $rootNode
            ->children()
            ->arrayNode('firewall_templates')
            ->prototype('array')
                ->children()
                    ->scalarNode('login_template')
                        ->isRequired(true)
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
