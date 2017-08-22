<?php

/*
 * This file is part of the francescotrucchia/broadway-extensions-bundle package.
 *
 * (c) Francesco Trucchia <francesco@trucchia.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BroadwayExtensions\Bundle\BroadwayExtensionsBundle;

use BroadwayExtensions\Bundle\BroadwayExtensionsBundle\Command\DomainCommandRunCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BroadwayExtensionsBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {

    }

    /**
     * {@inheritDoc}
     */
    public function registerCommands(Application $application)
    {
        $application->add(new DomainCommandRunCommand());
    }
}
