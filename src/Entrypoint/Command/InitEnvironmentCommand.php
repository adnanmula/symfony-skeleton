<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Entrypoint\Command;

use AdnanMula\Skeleton\Domain\Service\Persistence\Migration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class InitEnvironmentCommand extends Command
{
    /** @var array<Migration> */
    private array $migrations;

    public function __construct(Migration ...$migration)
    {
        $this->migrations = $migration;

        parent::__construct(null);
    }

    protected function configure(): void
    {
        $this->setDescription('Initialize environment');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        \array_walk(
            $this->migrations,
            function (Migration $migration) use ($output) {
                $migration->down();
                $migration->up();

                $output->writeln($this->migrationName($migration) . ' executed');
            },
        );

        return Command::SUCCESS;
    }

    private function migrationName(Migration $migration): string
    {
        $migrationName = \explode('\\', \get_class($migration));

        return $migrationName[\array_key_last($migrationName) - 1] . ' '
            . $migrationName[\array_key_last($migrationName)];
    }
}
