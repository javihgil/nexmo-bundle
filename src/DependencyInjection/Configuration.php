<?php

declare(strict_types=1);

namespace Jhg\NexmoBundle\DependencyInjection;

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
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('jhg_nexmo');
        $rootNode    = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('api_key')
                    ->isRequired()
                ->end()

                ->scalarNode('api_secret')
                    ->isRequired()
                ->end()

                ->enumNode('api_method')
                    ->defaultValue('GET')
                    ->values(['GET', 'POST'])
                ->end()

                ->scalarNode('from_name')
                    ->validate()
                        ->ifTrue(function ($s): bool {
                            return (strlen($s) > 11 || strlen($s) < 2) && 1 !== preg_match('/^[0-9a-z]{11}$/i', $s);
                        })
                            ->thenInvalid('Invalid from_name, only alphanumeric characters are allowed')
                        ->end()
                ->end()

                ->scalarNode('delivery_phone')
                    ->defaultNull()
                ->end()

                ->booleanNode('disable_delivery')
                    ->defaultFalse()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
