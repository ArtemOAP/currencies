<?php
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 13.12.2018
 * Time: 14:18
 */

namespace App\Api\Core;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('config');


        $rootNode
            ->children()
                ->arrayNode('routes')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('pattern')->isRequired()->end()
                            ->enumNode('method')->isRequired()->values(array('GET', 'POST', 'PUT'))->end()
                            ->booleanNode('public')->defaultFalse()->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }


}