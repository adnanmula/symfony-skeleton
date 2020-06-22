<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Domain\Model\User\Exception;

use AdnanMula\Skeleton\Domain\Model\Shared\Exception\NotFoundException;

final class UserNotExistsException extends NotFoundException
{
    public function __construct()
    {
        parent::__construct('User not exists.');
    }
}
