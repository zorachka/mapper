<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use Zorachka\Mapper\Attributes\Guid;
use Zorachka\Mapper\Attributes\PrimaryKey;
use Zorachka\Mapper\ReflectionMap;
use Zorachka\Mapper\Tests\Aggregate\GenericAggregate;

final class ReflectionMapTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function testTargetInstance(): void
    {
        self::assertInstanceOf(
            Simple::class,
            ReflectionMap::getTargetInstance(Simple::class),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetReflectionProperties(): void
    {
        self::assertIsArray(
            ReflectionMap::getReflectionProperties(Simple::class)
        );
        self::assertArrayHasKey(
            'privateField',
            ReflectionMap::getReflectionProperties(Simple::class),
        );
        self::assertArrayHasKey(
            'protectedField',
            ReflectionMap::getReflectionProperties(Simple::class),
        );
        self::assertArrayHasKey(
            'publicField',
            ReflectionMap::getReflectionProperties(Simple::class),
        );
        self::assertArrayHasKey(
            'dateTimeImmutableField',
            ReflectionMap::getReflectionProperties(Simple::class),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetClassAttributes(): void
    {
        $attributes = ReflectionMap::getClassAttributes(GenericAggregate::class);

        self::assertIsArray($attributes);
        self::assertArrayHasKey(\Zorachka\Mapper\Attributes\Aggregate::class, $attributes);
    }

    /**
     * @throws ReflectionException
     */
    public function testGetPropertyAttributes(): void
    {
        $attributes = ReflectionMap::getPropertyAttributes(GenericAggregate::class, 'id');

        self::assertIsArray($attributes);

        self::assertArrayHasKey(PrimaryKey::class, $attributes);
        self::assertArrayHasKey(Guid::class, $attributes);
    }
}
