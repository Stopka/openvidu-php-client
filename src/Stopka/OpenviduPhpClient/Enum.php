<?php


namespace Stopka\OpenviduPhpClient;


trait Enum
{
    /** @var string */
    private $value;

    /**
     * Enum constructor.
     * @param string $value
     * @throws EnumException
     */
    public function __construct(string $value)
    {
        if (!in_array($value, $this->getValues())) {
            throw new EnumException('Invalid enum value');
        }
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(self $enum): bool
    {
        return $enum->equalsString($this->value);
    }

    public function equalsString(string $enumString): bool
    {
        return $this->value == $enumString;
    }

    abstract public function getValues(): array;
}
