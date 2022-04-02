<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Migrations\Postgres;

use AdnanMula\Skeleton\Infrastructure\Persistence\Repository\DbalMigration;

final class V001 extends DbalMigration
{
    public function up(): void
    {
        $this->connection->executeStatement(
            'CREATE TABLE users (
                    id uuid NOT NULL,
                    reference character varying(16) NOT NULL
                        CONSTRAINT reference_unique UNIQUE,
                    username character varying(32) NOT NULL,
                    PRIMARY KEY(id)
                )',
        );
    }

    public function down(): void
    {
        $this->connection->executeStatement('DROP TABLE IF EXISTS "users"');
    }
}
