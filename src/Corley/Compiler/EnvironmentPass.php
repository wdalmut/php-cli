<?php
namespace Corley\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class EnvironmentPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $parameters = [];

        foreach ($_SERVER as $key => $value) {
            if (strpos($key, "APP__") === 0) {
                $container->setParameter(strtolower(str_replace('__', '.', substr($key, 5))), $value);
            }
        }
    }
}

