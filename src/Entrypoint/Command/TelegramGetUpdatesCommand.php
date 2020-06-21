<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Entrypoint\Command;

use AdnanMula\Skeleton\Domain\Service\Communication\CommunicationClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class TelegramGetUpdatesCommand extends Command
{
    private string $botToken;
    private CommunicationClient $communication;
    private MessageBusInterface $bus;

    public function __construct(string $botToken, CommunicationClient $communication, MessageBusInterface $bus)
    {
        $this->botToken = $botToken;
        $this->communication = $communication;
        $this->bus = $bus;

        parent::__construct(null);
    }

    protected function configure(): void
    {
        $this->setDescription('Process telegram messages');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = new \Telegram($this->botToken);

        $client->getUpdates();

        for ($i = 0; $i < $client->UpdateCount(); $i++) {
            $client->serveUpdate($i);

            $command = $this->getCommand(
                (string) $client->ChatID(),
                $client->Text(),
                $client->messageFromGroup() ? $client->messageFromGroupTitle() : $client->Username(),
            );

            if (null !== $command) {
                $this->bus->dispatch($command);
                $this->communication->say('Ok!', $client->ChatID());
            }
        }

        return Command::SUCCESS;
    }

    private function getCommand(string $reference, string $text, string $username)
    {
        $arguments = \explode(' ', $text);
        $command = \array_shift($arguments);
        $isFromGroup = \strpos($command, '@');

        $command = \substr(
            $command,
            0,
            $isFromGroup !== false && $isFromGroup !== 0 ? $isFromGroup : \strlen($command),
        );

        switch (true) {
            default:
                return null;
        }
    }
}
