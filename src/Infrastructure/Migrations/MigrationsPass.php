<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Infrastructure\Migrations;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class MigrationsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (false === $container->has(MigrationsRegistry::class)) {
            throw new \InvalidArgumentException(MigrationsRegistry::class . ' has to be defined as a service');
        }

        $definition = $container->findDefinition(MigrationsRegistry::class);
        $taggedServices = $container->findTaggedServiceIds('skeleton.migration');

        foreach (\array_keys($taggedServices) as $serviceId) {
            $definition->addMethodCall('add', [new Reference($serviceId)]);
        }
    }
}
