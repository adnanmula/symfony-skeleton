<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Domain\Model\Shared\ValueObject;

use Ramsey\Uuid\Uuid;

class UuidValueObject extends StringValueObject
{
    public static function from(string $value): static
    {
        return new static(Uuid::fromString($value)->toString());
    }

    public static function v4(): static
    {
        return new static(Uuid::uuid4()->toString());
    }
}
