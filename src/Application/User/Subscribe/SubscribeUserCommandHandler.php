<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Application\User\Subscribe;

use AdnanMula\Skeleton\Domain\Service\User\UserCreator;

final class SubscribeUserCommandHandler
{
    private UserCreator $creator;

    public function __construct(UserCreator $creator)
    {
        $this->creator = $creator;
    }

    public function __invoke(SubscribeUserCommand $command): void
    {
        $this->creator->execute(
            $command->id(),
            $command->reference(),
            $command->username(),
        );
    }
}
