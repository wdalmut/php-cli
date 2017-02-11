<?php
namespace Corley\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CommandPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('console')) {
            return;
        }

        $definition = $container->findDefinition('console');

        $commands = $container->findTaggedServiceIds('app.command');
        foreach ($commands as $id => $tags) {
            $definition->addMethodCall('add', array(new Reference($id)));
        }
    }
}
