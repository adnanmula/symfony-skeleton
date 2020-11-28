<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Infrastructure\Migrations;

use AdnanMula\Skeleton\Domain\Service\Persistence\Migration;

final class MigrationsRegistry
{
    private array $registry;

    public function __construct()
    {
        $this->registry = [];
    }

    public function add(Migration $migration): void
    {
        $this->registry[\get_class($migration)] = $migration;
    }

    public function execute(): void
    {
        $registry = $this->registry;

        \sort($registry, \SORT_NATURAL);

        \array_walk(
            $registry,
            static function (Migration $migration) {
                $migration->down();
                $migration->up();
            },
        );
    }
}
