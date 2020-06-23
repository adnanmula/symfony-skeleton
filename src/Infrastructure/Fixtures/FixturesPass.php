<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Infrastructure\Fixtures;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class FixturesPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (false === $container->has(FixturesRegistry::class)) {
            throw new \InvalidArgumentException(FixturesRegistry::class . ' has to be defined as a service');
        }

        $definition = $container->findDefinition(FixturesRegistry::class);
        $taggedServices = $container->findTaggedServiceIds('skeleton.fixture');

        foreach (\array_keys($taggedServices) as $serviceId) {
            $definition->addMethodCall('addFixture', [new Reference($serviceId)]);
        }
    }
}
