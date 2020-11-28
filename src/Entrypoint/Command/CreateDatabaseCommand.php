<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Entrypoint\Command;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CreateDatabaseCommand extends Command
{
    public const NAME = 'skeleton:env:database';

    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;

        parent::__construct(null);
    }

    protected function configure(): void
    {
        $this->setName(self::NAME)
            ->setDescription('Initialize database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
//      TODO inject tmp connection and remove getParams

        $tmpParams = $this->connection->getParams();

        unset($tmpParams['url']);
        unset($tmpParams['dbname']);

        $tmpConnection = DriverManager::getConnection($tmpParams);
        $tmpConnection->getSchemaManager()->dropAndCreateDatabase($this->connection->getParams()['dbname']);

        return Command::SUCCESS;
    }
}
