<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Domain\Service\User;

use AdnanMula\Skeleton\Domain\Model\User\Exception\UserAlreadyExistsException;
use AdnanMula\Skeleton\Domain\Model\User\User;
use AdnanMula\Skeleton\Domain\Model\User\UserRepository;
use AdnanMula\Skeleton\Domain\Model\User\ValueObject\UserId;
use AdnanMula\Skeleton\Domain\Model\User\ValueObject\UserReference;
use AdnanMula\Skeleton\Domain\Model\User\ValueObject\UserUsername;

final class UserCreator
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(UserId $id, UserReference $reference, UserUsername $username): void
    {
        $user = $this->repository->byReference($reference);

        if (null !== $user) {
            throw new UserAlreadyExistsException();
        }

        $this->repository->save(
            User::create($id, $reference, $username),
        );
    }
}
