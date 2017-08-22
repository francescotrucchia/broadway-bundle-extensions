<?php
/*
 * This file is part of the francescotrucchia/broadway package.
 *
 * (c) Francesco Trucchia <francesco@trucchia.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BroadwayExtensions\Bundle\BroadwayExtensionsBundle\Command;

use BroadwayExtensions\CommandHandling\CommandBuilder;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DomainCommandRunCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('broadway-extensions:command:run')
            ->addOption('classesMapFile', 'cmf', InputOption::VALUE_OPTIONAL, 'File with array classes map')
            ->addArgument('className', InputArgument::REQUIRED, 'Command class name')
            ->addArgument('arguments', InputArgument::IS_ARRAY, 'Command arguments')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $commandBus = $this->getContainer()->get('broadway.command_handling.command_bus');
        $classesMap = [];
        if ($input->hasOption('classesMapFile')) {
            $classesMap = require($input->getOption('classesMapFile'));
        }

        $builder = new CommandBuilder();
        $builder->setClassesMap($classesMap);
        $command = $builder->build($input->getArgument('className'), $input->getArgument('arguments'));

        $commandBus->dispatch($command);
    }
}
