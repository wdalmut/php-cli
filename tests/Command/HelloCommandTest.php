<?php
namespace Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class HelloCommandTest extends TestCase
{
    public function testHello()
    {
        $application = new Application();
        $application->add(new HelloCommand());

        $command = $application->find('app:hello');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $this->assertRegExp('/Hello/', $commandTester->getDisplay());
    }
}

