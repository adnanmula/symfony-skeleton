<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Infrastructure\Fixtures;

use Doctrine\DBAL\Connection;

abstract class DbalFixture
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
}
