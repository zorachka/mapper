<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Tests;

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
            'publicField' => 3,
        ]);

        self::assertEquals(1, $testObject->getPrivateField());
        self::assertEquals(2, $testObject->getProtectedField());
        self::assertEquals(3, $testObject->publicField);
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
}
