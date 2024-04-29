<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Domain\Model\Shared\ValueObject;

class StringValueObject
{
    private string $value;

    final protected function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equalTo(self $other): bool
    {
        return static::class === $other::class && $this->value === $other->value;
    }

    final public function jsonSerialize(): string
    {
        return $this->value;
    }

    public static function from(string $value)
    {
        return new static($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
