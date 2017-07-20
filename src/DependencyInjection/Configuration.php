<?php

/**
 * AnimeDb package.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2011, Peter Gribanov
 * @license   http://opensource.org/licenses/GPL-3.0 GPL v3
 */

namespace AnimeDb\Bundle\SmotretAnimeBrowserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Config tree builder.
     *
     * Example config:
     *
     * anime_db_smotret_anime_browser:
     *     host: 'http://smotret-anime.ru'
     *     prefix: '/api/'
     *     client: 'My Custom Bot 1.0'
     *
     * @return ArrayNodeDefinition
     */
    public function getConfigTreeBuilder()
    {
        return (new TreeBuilder())
            ->root('anime_db_smotret_anime_browser')
                ->children()
                    ->scalarNode('host')
                        ->defaultValue('http://smotret-anime.ru')
                        ->cannotBeEmpty()
                    ->end()
                    ->scalarNode('prefix')
                        ->defaultValue('/api/')
                        ->cannotBeEmpty()
                    ->end()
                    ->scalarNode('client')
                        ->cannotBeEmpty()
                        ->isRequired()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
