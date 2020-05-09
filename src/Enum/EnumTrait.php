<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Enum;

trait EnumTrait
{
    /** @var string */
    private string $value;

    /**
     * EnumTrait constructor.
     *
     * @param  string $value
     * @throws EnumException
     */
    public function __construct(string $value)
    {
        if (!in_array($value, static::getValues(), true)) {
            $class = self::class;
            throw new EnumException("Invalid string value '${value}' for enum '${class}'");
        }
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @param  self $enum
     * @return bool
     */
    public function equals(self $enum): bool
    {
        return $enum->equalsString($this->value);
    }

    /**
     * @param  string $enumString
     * @return bool
     */
    public function equalsString(string $enumString): bool
    {
        return $this->value === $enumString;
    }

    /**
     * @return string[]
     */
    abstract public static function getValues(): array;
}
