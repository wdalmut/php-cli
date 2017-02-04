<?php
require __DIR__."/../vendor/autoload.php";

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$container = new ContainerBuilder();
$loader = new YamlFileLoader($container, new FileLocator(__DIR__));;
$loader->load(__DIR__."/../app/config/services.yml");
$loader->load(__DIR__."/../app/config/commands.yml");

if(!file_exists(__DIR__."/../app/config/parameters.yml")){
    echo "Copy app/config/parameters.yml.dist in app/config/parameters.yml and set your configurations \n\r";
    exit;
}
$loader->load(__DIR__."/../app/config/parameters.yml");

$commands = $container->findTaggedServiceIds("app.command");

$application = $container->get("console");

foreach ($commands as $id => $description) {
    $service = $container->get($id);
    $application->add($service);
}

$application->run();
