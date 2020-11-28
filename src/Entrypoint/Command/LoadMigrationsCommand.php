<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Entrypoint\Command;

use AdnanMula\Skeleton\Infrastructure\Migrations\MigrationsRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class LoadMigrationsCommand extends Command
{
    private MigrationsRegistry $registry;

    public function __construct(MigrationsRegistry $registry)
    {
        $this->registry = $registry;

        parent::__construct(null);
    }

    protected function configure(): void
    {
        $this->setDescription('Initialize environment');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->registry->execute();

        return Command::SUCCESS;
    }
}
