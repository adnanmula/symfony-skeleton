<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Domain\Service\Persistence;

interface Fixture
{
    public function load(): void;
    public function isLoaded(): bool;
    /** @return array<Fixture> */
    public function dependants(): array;
}
