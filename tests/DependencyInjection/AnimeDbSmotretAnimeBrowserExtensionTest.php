<?php

/**
 * AnimeDb package.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2011, Peter Gribanov
 * @license   http://opensource.org/licenses/GPL-3.0 GPL v3
 */

namespace AnimeDb\Bundle\SmotretAnimeBrowserBundle\Tests\DependencyInjection;

use AnimeDb\Bundle\SmotretAnimeBrowserBundle\DependencyInjection\AnimeDbSmotretAnimeBrowserExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class AnimeDbSmotretAnimeBrowserExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|ContainerBuilder
     */
    private $container;

    /**
     * @var AnimeDbSmotretAnimeBrowserExtension
     */
    private $extension;

    protected function setUp()
    {
        $this->container = $this->getMock(ContainerBuilder::class);
        $this->extension = new AnimeDbSmotretAnimeBrowserExtension();
    }

    /**
     * @return array
     */
    public function config()
    {
        return [
            [
                [
                    'anime_db_smotret_anime_browser' => [
                        'client' => 'My Custom Bot 1.0',
                    ],
                ],
                'http://smotret-anime.ru',
                '/api/',
                'My Custom Bot 1.0',
            ],
            [
                [
                    'anime_db_smotret_anime_browser' => [
                        'host' => 'https://smotret-anime.ru',
                        'prefix' => '/api/v1/',
                        'client' => 'My Custom Bot 1.0',
                    ],
                ],
                'https://smotret-anime.ru',
                '/api/v1/',
                'My Custom Bot 1.0',
            ],
        ];
    }

    /**
     * @dataProvider config
     *
     * @param array  $config
     * @param string $host
     * @param string $prefix
     * @param string $client
     */
    public function testLoad(array $config, $host, $prefix, $client)
    {
        $browser = $this->getMock(Definition::class);
        $browser
            ->expects($this->at(0))
            ->method('replaceArgument')
            ->with(2, $host)
            ->will($this->returnSelf())
        ;
        $browser
            ->expects($this->at(1))
            ->method('replaceArgument')
            ->with(3, $prefix)
            ->will($this->returnSelf())
        ;
        $browser
            ->expects($this->at(2))
            ->method('replaceArgument')
            ->with(4, $client)
            ->will($this->returnSelf())
        ;

        $this->container
            ->expects($this->once())
            ->method('getDefinition')
            ->with('anime_db.smotret_anime.browser')
            ->will($this->returnValue($browser))
        ;

        $this->extension->load($config, $this->container);
    }
}
