# Command line applications

A simple base point for command line applications

## Install with composer

```sh
composer create-project corley/cli ./my-app ~1
```

## Usage

Everything is ruled by the dependency injection container. In `services.yml` you
can define services and in `commands.yml` you can add commands.

### Add commands

Every command must be tagged as `app.comand` (autoloading)

```yml
# commands.yml
hello.command:
  class: Command\MyCommand
  arguments:
    - "%hello%"
  tags:
    - {name: app.command}
```

### Add services

```yml
# services.yml
services:
  mailer:
    class: MyApp\Mailer
    arguments:
      - mailer.transport
  mailer.transport:
    class: MyApp\Sendmail
```

## Create a command

Just `Symfony` commands

```php
<?php
namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class MyCommand extends Command
{
    protected function configure()
    {
        $this->setName("app:command:one")
            ->setDescription("Example command")
            ->setHelp("Example command");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // here your logic
    }
}
```

### Using dependency injection in your commands

Everything is ruled by dependency injection, so your command should be composed
with the dependency injection container

```php
<?php
namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class MyCommand extends Command
{
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;

        parent::__construct();
    }

    // other command methods
}
```

in your `commands.yml`

```yml
my.command:
  class: Command\MyCommand
  arguments:
    - "@mailer"
  tags:
    - {name: app.command}

```

## Environment variables

Environment variable should be prefixed with: `APP__` and those variables will
be propagated as parameters

```sh
APP__HELLO=walter ./bin/console app:hello
Hello walter!
```

Rules:

 * variables are replaced as lowercase strings
   * `APP__WALTER=test -> setParameter('walter,'test');`
 * `_` remains `_`
   * `APP__WALTER_TEST=test -> setParameter('walter_test', 'test');`
 * `__` will be `.`
   * `APP__WALTER__TEST=test -> setParameter('walter.test', 'test');`

## Testing commands

```php
class MyCommandTest extends TestCase
{
    public function testBaseCheck()
    {
		$command = new MyCommand();
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $this->assertRegExp('/Hello/', $commandTester->getDisplay());
    }
}
```

Inject your mocks manually

```php
class MyCommandTest extends TestCase
{
    public function testBaseCheck()
    {
        $mock = $this->prophesize(Mailer::class);
        $mock->send(Argument::Any())->willReturn(true);

		$command = new MyCommand($mock->reveal());
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $this->assertRegExp('/Hello/', $commandTester->getDisplay());
    }
}
```

## Examples

```sh
$ cd my-app
$ ./bin/console app:hello
$ Hello test!
```

Check the help message

```sh
$ ./bin/console
My App Name

Usage:
  command [options] [arguments]

Options:
  -h, --help            Display this help message
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi            Force ANSI output
      --no-ansi         Disable ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  help       Displays help for a command
  list       Lists commands
 app
  app:hello  Say hello
```
