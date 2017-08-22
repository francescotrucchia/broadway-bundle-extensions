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

use Broadway\CommandHandling\SimpleCommandBus;
use Broadway\CommandHandling\SimpleCommandHandler;
use BroadwayExtensions\Bundle\BroadwayExtensionsBundle\TestCase;
use Prophecy\Argument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;

class DomainCommandRunCommandTest extends TestCase
{
    /**
     * @test
     */
    public function execute_command()
    {
        $input = $this->prophesize(InputInterface::class);
        $output = $this->prophesize(OutputInterface::class);
        $container = $this->prophesize(Container::class);

        $commandBus = new SimpleCommandBus();
        $commandBus->subscribe(new TestCommandHandler($this, '1', 'Francesco'));
        $container->get('broadway.command_handling.command_bus')->willReturn($commandBus);

        $input->bind(Argument::any())->shouldBeCalled();
        $input->isInteractive()->shouldBeCalled();
        $input->hasArgument('command')->shouldBeCalled();
        $input->validate()->shouldBeCalled();
        $input->hasOption('classesMapFile')->shouldBeCalled();
        $input->getArgument('arguments')->willReturn(['1', 'Francesco']);
        $input->getArgument('className')->willReturn(Testcommand::class);

        $command = new DomainCommandRunCommand();
        $command->setContainer($container->reveal());
        $command->run($input->reveal(), $output->reveal());
    }
}

class TestCommandHandler extends SimpleCommandHandler
{
    private $testCase;
    private $expectedId;
    private $expectedName;

    public function __construct(TestCase $testCase, $expectedId, $expectedName)
    {
        $this->testCase = $testCase;
        $this->expectedId = $expectedId;
        $this->expectedName = $expectedName;
    }

    protected function handleTestCommand(TestCommand $command)
    {
       $this->testCase->assertEquals($this->expectedId, $command->uuid);
       $this->testCase->assertEquals($this->expectedName, $command->name);
    }
}

class TestCommand
{
    public $uuid;
    public $name;

    public function __construct($uuid, $name)
    {
        $this->uuid = $uuid;
        $this->name = $name;
    }
}
