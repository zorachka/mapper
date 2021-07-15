<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use Zorachka\Mapper\Extractor;

final class ExtractorTest extends TestCase
{
    private Extractor $extractor;

    public function setUp(): void
    {
        parent::setUp();
        $this->extractor = new Extractor();
    }

    /**
     * @throws ReflectionException
     */
    public function testFull()
    {
        $testObject = new TestClass(1, 2, 3);

        $row = $this->extractor->extract($testObject, ['publicField', 'protectedField', 'privateField']);

        self::assertEquals([
            'publicField' => $testObject->publicField,
            'protectedField' => $testObject->getProtectedField(),
            'privateField' => $testObject->getPrivateField(),
        ], $row);
    }

    /**
     * @throws ReflectionException
     */
    public function testPartial()
    {
        $testObject = new TestClass(1, 2, 3);
        $row = $this->extractor->extract($testObject, ['protectedField', 'privateField']);

        self::assertEquals([
            'protectedField' => $testObject->getProtectedField(),
            'privateField' => $testObject->getPrivateField(),
        ], $row);
    }

    public function testNotExist()
    {
        self::expectException(ReflectionException::class);

        $testObject = new TestClass(1, 2, 3);
        $this->extractor->extract($testObject, ['publicField', 'otherField']);
    }
}
