<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Application\User\Unsubscribe;

use AdnanMula\Skeleton\Application\Shared\Command;
use AdnanMula\Skeleton\Domain\Model\User\ValueObject\UserReference;
use Assert\Assert;

final readonly class UnsubscribeUserCommand implements Command
{
    public const array COMMAND = ['/unsubscribe', '/unsub'];

    private UserReference $reference;

    public function __construct($reference)
    {
        Assert::lazy()
            ->that($reference, 'reference')->string()->notBlank()
            ->verifyNow();

        $this->reference = UserReference::from($reference);
    }

    public function reference(): UserReference
    {
        return $this->reference;
    }
}
