<?php
namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class HelloCommand extends Command
{
    private $name;

    public function __construct($name = false)
    {
        $this->name = $name;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName("app:hello")
            ->setDescription("Say hello")
            ->setHelp("Just say hello");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf("Hello %s!", $this->name));
    }
}
