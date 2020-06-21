<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Domain\Model\Shared\ValueObject;

class StringValueObject
{
    private $value;

    protected function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equalTo(StringValueObject $other): bool
    {
        return \get_class($other) === static::class && $this->value === $other->value;
    }

    final public function jsonSerialize(): string
    {
        return $this->value;
    }

    public static function from(string $value): self
    {
        return new static($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
