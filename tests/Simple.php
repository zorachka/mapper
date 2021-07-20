<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Tests;

use DateTimeImmutable;

final class Simple
{
    private string $privateField;
    protected int $protectedField;
    public bool $publicField;
    private DateTimeImmutable $dateTimeImmutableField;

    private bool $constructorCalled = false;

    public function __construct(
        string $privateField,
        int $protectedField,
        bool $publicField,
        DateTimeImmutable $dateTimeImmutable,
    ) {
        $this->constructorCalled = true;
        $this->privateField = $privateField;
        $this->protectedField = $protectedField;
        $this->publicField = $publicField;
        $this->dateTimeImmutableField = $dateTimeImmutable;
    }

    /**
     * @return string
     */
    public function getPrivateField(): string
    {
        return $this->privateField;
    }

    /**
     * @return int
     */
    public function getProtectedField(): int
    {
        return $this->protectedField;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDateTimeImmutableField(): DateTimeImmutable
    {
        return $this->dateTimeImmutableField;
    }

    /**
     * @return bool
     */
    public function getConstructorCalled(): bool
    {
        return $this->constructorCalled;
    }
}
