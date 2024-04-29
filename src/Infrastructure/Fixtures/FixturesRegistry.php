<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Infrastructure\Fixtures;

use AdnanMula\Skeleton\Domain\Service\Persistence\Fixture;

final class FixturesRegistry
{
    private array $registry;

    public function __construct()
    {
        $this->registry = [];
    }

    public function add(Fixture $fixture): void
    {
        $this->registry[$fixture::class] = $fixture;
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
        foreach ($fixture->dependants() as $dependant) {
            $this->load($this->registry[$dependant]);
        }

        if (false === $fixture->isLoaded()) {
            $fixture->load();
        }
    }
}
