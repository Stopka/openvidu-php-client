<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\Enum\EnumException;
use Stopka\OpenviduPhpClient\Tests\Enum\TestingEnum;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

Assert::throws(
    fn() => new TestingEnum('Boo'),
    EnumException::class,
    "Invalid string value 'Boo' for enum 'Stopka\OpenviduPhpClient\Tests\Enum\TestingEnum'"
);

$foo = new TestingEnum(TestingEnum::FOO);
$foo2 = new TestingEnum(TestingEnum::FOO);
$bar = new TestingEnum(TestingEnum::BAR);

Assert::true($foo->equalsString(TestingEnum::FOO));
Assert::false($foo->equalsString(TestingEnum::BAR));
Assert::true($foo->equals($foo));
Assert::true($foo->equals($foo2));
Assert::false($foo->equals($bar));
Assert::same($foo::FOO, (string)$foo);
