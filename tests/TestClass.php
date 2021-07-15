<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Tests;

final class TestClass
{
    private mixed $privateField;
    protected mixed $protectedField;
    public mixed $publicField;

    private bool $constructorCalled = false;

    public function __construct(mixed $privateField, mixed $protectedField, mixed $publicField)
    {
        $this->constructorCalled = true;
        $this->privateField = $privateField;
        $this->protectedField = $protectedField;
        $this->publicField = $publicField;
    }

    /**
     * @return mixed
     */
    public function getPrivateField(): mixed
    {
        return $this->privateField;
    }

    /**
     * @return mixed
     */
    public function getProtectedField(): mixed
    {
        return $this->protectedField;
    }

    /**
     * @return bool
     */
    public function getConstructorCalled(): bool
    {
        return $this->constructorCalled;
    }
}
