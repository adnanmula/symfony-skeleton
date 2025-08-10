<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Application\User\Unsubscribe;

use AdnanMula\Skeleton\Domain\Service\User\UserRemover;

final readonly class UnsubscribeUserCommandHandler
{
    public function __construct(
        private UserRemover $remover,
    ) {}

    public function __invoke(UnsubscribeUserCommand $command): void
    {
        $this->remover->execute($command->reference());
    }
}
