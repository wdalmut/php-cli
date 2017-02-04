<?php
namespace Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class HelloCommandTest extends TestCase
{
    public function testHello()
    {
        $command = new HelloCommand();
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $this->assertRegExp('/Hello/', $commandTester->getDisplay());
    }
}

