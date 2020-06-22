<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Domain\Service\User;

use AdnanMula\Skeleton\Domain\Model\User\Exception\UserNotExistsException;
use AdnanMula\Skeleton\Domain\Model\User\User;
use AdnanMula\Skeleton\Domain\Model\User\UserRepository;
use AdnanMula\Skeleton\Domain\Model\User\ValueObject\UserId;

final class UserFinder
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(UserId $id): User
    {
        $user = $this->repository->byId($id);

        if (null === $user) {
            throw new UserNotExistsException();
        }

        return $user;
    }
}
