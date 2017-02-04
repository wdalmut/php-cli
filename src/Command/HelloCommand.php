<?php
namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class HelloCommand extends Command
{
    protected function configure()
    {
        $this->setName("app:hello")
            ->setDescription("Say hello")
            ->setHelp("Just say hello");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Hello!");
    }
}
