<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Entrypoint\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class InitEnvironmentCommand extends Command
{
    public const NAME = 'skeleton:env:init';

    public function __construct()
    {
        parent::__construct(null);
    }

    protected function configure(): void
    {
        $this->setName(self::NAME)
            ->setDescription('Initialize environment');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $app = $this->getApplication();

        if (null === $app) {
            throw new \RuntimeException('Kernel not initialized');
        }

        $app->setAutoExit(false);

        $app->run(new ArrayInput(['command' => 'skeleton:env:database']));
        $app->run(new ArrayInput(['command' => 'skeleton:env:migrations']));
        $app->run(new ArrayInput(['command' => 'skeleton:env:fixtures']));

        return Command::SUCCESS;
    }
}
