<?php

/*
 * This file is part of the francescotrucchia/broadway package.
 *
 * (c) Francesco Trucchia <francesco@trucchia.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BroadwayExtensions\Bundle\BroadwayExtensionsBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class BroadwayExtensionsBundleTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_bundle()
    {
        $container = new ContainerBuilder();

        $bundle = new BroadwayExtensionsBundle();
        $bundle->build($container);

        $container->compile();
    }
}
