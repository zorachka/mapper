<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use Zorachka\Mapper\Hydrator;
use Zorachka\Mapper\Tests\Aggregate\Aggregate;
use Zorachka\Mapper\Tests\Aggregate\AggregateId;

final class AggregateTest extends TestCase
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
        /** @var Aggregate $aggregate */
        $aggregate = $this->hydrator->hydrate(Aggregate::class, [
            'id' => '00000000-0000-0000-0000-000000000000',
            'string' => 'string value',
            'boolean' => 0,
            'integer' => -1,
            'dateTime' => '2021-07-20 14:59:00',
        ]);

        self::assertEquals([
            'id' => '00000000-0000-0000-0000-000000000000',
            'string' => 'string value',
            'boolean' => 0,
            'integer' => -1,
            'dateTime' => '2021-07-20 14:59:00',
        ], $aggregate->state());
    }

    /**
     * @throws ReflectionException
     */
    public function testExtract(): void
    {
        $aggregate = Aggregate::create(
            AggregateId::nil(),
            'string value',
            -1,
            false,
            new \DateTimeImmutable('2021-07-20 14:59:00'),
        );
        $data = $this->hydrator->extract($aggregate);

        \var_dump($data);
    }
}
