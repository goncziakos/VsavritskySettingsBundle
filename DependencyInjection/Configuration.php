<?php

namespace Vsavritsky\SettingsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('vsavritsky_settings');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('enable_short_service')
                    ->defaultTrue()
                ->end()
                ->scalarNode('html_widget')
                    ->defaultNull()
                ->end()
                ->scalarNode('cache_provider')
                    ->defaultNull()
                ->end()
                ->booleanNode('use_category_comment')
                    ->defaultFalse()
                ->end()
                ->arrayNode('ckeditor')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('base_path')
                            ->defaultNull()
                        ->end()
                        ->scalarNode('js_path')
                            ->defaultNull()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
