<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Infrastructure\Fixtures;

use AdnanMula\Skeleton\Domain\Service\Persistence\Fixture;

final class FixturesRegistry
{
    private array $registry;

    public function __construct(Fixture ...$fixtures)
    {
        \array_walk(
            $fixtures,
            fn (Fixture $fixture) => $this->registry[\get_class($fixture)] = $fixture,
        );
    }

    public function execute(): void
    {
        \array_walk(
            $this->registry,
            function (Fixture $fixture) {
                $this->load($fixture);
            },
        );
    }

    private function load(Fixture $fixture): void
    {
        $dependants = $fixture->dependants();

        \array_walk(
            $dependants,
            function (string $fixture) {
                $this->load($this->registry[$fixture]);
            },
        );

        if (false === $fixture->isLoaded()) {
            $fixture->load();
        }
    }
}
