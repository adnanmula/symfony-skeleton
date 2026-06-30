<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Entrypoint\Command;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception\DatabaseDoesNotExist;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CreateDatabaseCommand extends Command
{
    public const string NAME = 'environment:database';

    public function __construct(
        private readonly Connection $defaultConnection,
        private readonly Connection $connection,
    ) {
        parent::__construct(null);
    }

    protected function configure(): void
    {
        $this->setName(self::NAME)
            ->setDescription('Initialize database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var array{'dbname': string} $params */
        $params = $this->connection->getParams();
        $dbName = $params['dbname'];

        try {
            $this->defaultConnection->createSchemaManager()->dropDatabase($dbName);
        } catch (DatabaseDoesNotExist) {
        }

        $this->defaultConnection->createSchemaManager()->createDatabase($dbName);

        return Command::SUCCESS;
    }
}
