<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Tests;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Zorachka\Mapper\Hydrator;

final class HydratorTest extends TestCase
{
    private Hydrator $hydrator;

    public function setUp(): void
    {
        parent::setUp();
        $this->hydrator = new Hydrator();
    }

    /**
     * @throws ReflectionException
     */
    public function testHydrate(): void
    {
        /** @var TestClass $testObject */
        $testObject = $this->hydrator->hydrate(TestClass::class, [
            'privateField' => 1,
            'protectedField' => 2,
            'publicField' => 0,
        ]);

        self::assertEquals('1', $testObject->getPrivateField());
        self::assertEquals(2, $testObject->getProtectedField());
        self::assertEquals(false, $testObject->publicField);
        self::assertFalse($testObject->getConstructorCalled());
    }

    public function testNotExist()
    {
        self::expectException(ReflectionException::class);

        $this->hydrator->hydrate(TestClass::class, [
            'publicField' => 1,
            'otherField' => 2,
        ]);
    }

    /**
     * @throws ReflectionException
     */
    public function testExtractFull()
    {
        $testObject = new TestClass('1', 2, false, new DateTimeImmutable());

        $row = $this->hydrator->extract($testObject, ['constructorCalled']);

        self::assertEquals([
            'publicField' => $testObject->publicField,
            'protectedField' => $testObject->getProtectedField(),
            'privateField' => $testObject->getPrivateField(),
            'dateTimeImmutableField' => $testObject->getDateTimeImmutableField(),
        ], $row);
    }

    /**
     * @throws ReflectionException
     */
    public function testExtractPartial()
    {
        $testObject = new TestClass('1', 2, false, new DateTimeImmutable());
        $row = $this->hydrator->extract($testObject, ['constructorCalled', 'publicField', 'dateTimeImmutableField']);

        self::assertEquals([
            'protectedField' => $testObject->getProtectedField(),
            'privateField' => $testObject->getPrivateField(),
        ], $row);
    }
}
