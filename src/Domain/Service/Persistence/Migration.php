<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Domain\Service\Persistence;

interface Migration
{
    public function up(): void;
    public function down(): void;
}
