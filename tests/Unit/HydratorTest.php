<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Tests\Unit;

use DateTimeImmutable;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Zorachka\Mapper\Hydrators\DateTimeImmutablePropertyHydrator;
use Zorachka\Mapper\Hydrators\DefaultPropertyHydrator;
use Zorachka\Mapper\Hydrators\EnumPropertyHydrator;
use Zorachka\Mapper\Hydrators\ObjectHydratorUsingReflection;
use Zorachka\Mapper\Hydrators\ObjectPropertyHydrator;
use Zorachka\Mapper\KeyFormatters\KeyFormatterForSnakeCasing;
use Zorachka\Mapper\Tests\Datasets\ValueObjects\DateTimeRFC3339;
use Zorachka\Mapper\Tests\Datasets\ValueObjects\Id;
use Zorachka\Mapper\Tests\Datasets\ValueObjects\PaymentStatusString;
use Zorachka\Mapper\Tests\Datasets\ValueObjects\PostTitle;
use Zorachka\Mapper\Tests\Datasets\ValueObjects\Price;
use Zorachka\Mapper\Tests\Datasets\ValueObjects\PublishedStatusInt;
use Zorachka\Mapper\Tests\Datasets\WithNullableValueObject;
use Zorachka\Mapper\Tests\Datasets\WithScalarAndDateTimeImmutable;
use Zorachka\Mapper\Tests\Datasets\WithScalarAndStatusEnum;
use Zorachka\Mapper\Tests\Datasets\WithSomeNullableValueObjects;
use Zorachka\Mapper\Tests\Datasets\WithValueObjects;
use Zorachka\Mapper\Tests\Datasets\WithValueObjectsAndSkipAttribute;

/**
 * @internal
 */
final class HydratorTest extends TestCase
{
    public function providesData(): array
    {
        return [
            'WithScalarAndDateTimeImmutable' => [
                WithScalarAndDateTimeImmutable::class,
                [
                    'id' => '1',
                    'status' => '1',
                    'is_available' => false,
                    'created_at' => '2021-01-01 00:00:00',
                ],
                new WithScalarAndDateTimeImmutable(
                    id: '1',
                    status: 1,
                    isAvailable: false,
                    createdAt: new DateTimeImmutable('2021-01-01 00:00:00'),
                ),
            ],
            'WithScalarAndStatusEnum' => [
                WithScalarAndStatusEnum::class,
                [
                    'id' => '1',
                    'published_status' => 1,
                    'payment_status' => 'paid',
                    'created_at' => '2021-01-01 00:00:00',
                ],
                new WithScalarAndStatusEnum(
                    id: '1',
                    publishedStatus: PublishedStatusInt::PUBLISHED,
                    paymentStatus: PaymentStatusString::PAID,
                    createdAt: new DateTimeImmutable('2021-01-01 00:00:00'),
                ),
            ],
            'WithValueObjects' => [
                WithValueObjects::class,
                [
                    'id' => '9b1deb4d-3b7d-4bad-9bdd-2b0d7b3dcb6d',
                    'title' => 'Hello World',
                    'price_amount' => 100,
                    'price_currency' => 'USD',
                    'created_at' => '2023-05-11T00:00:00+08:00',
                ],
                WithValueObjects::create(
                    Id::fromString('9b1deb4d-3b7d-4bad-9bdd-2b0d7b3dcb6d'),
                    PostTitle::fromString('Hello World'),
                    Price::of(100, 'USD'),
                    DateTimeRFC3339::fromString('2023-05-11T00:00:00+08:00'),
                ),
            ],
            'WithSomeNullableValueObjects' => [
                WithSomeNullableValueObjects::class,
                [
                    'id' => '9b1deb4d-3b7d-4bad-9bdd-2b0d7b3dcb6d',
                    'title' => 'Hello World',
                    'price_amount' => 100,
                    'price_currency' => 'USD',
                    'created_at' => null,
                ],
                WithSomeNullableValueObjects::create(
                    Id::fromString('9b1deb4d-3b7d-4bad-9bdd-2b0d7b3dcb6d'),
                    PostTitle::fromString('Hello World'),
                    Price::of(100, 'USD'),
                    null,
                ),
            ],
            'WithNullableValueObject' => [
                WithNullableValueObject::class,
                [
                    'id' => '9b1deb4d-3b7d-4bad-9bdd-2b0d7b3dcb6d',
                    'last_name' => null,
                ],
                WithNullableValueObject::create(
                    Id::fromString('9b1deb4d-3b7d-4bad-9bdd-2b0d7b3dcb6d'),
                    null,
                ),
            ],
            'WithValueObjectsAndSkipAttribute' => [
                WithValueObjectsAndSkipAttribute::class,
                [
                    'id' => '9b1deb4d-3b7d-4bad-9bdd-2b0d7b3dcb6d',
                    'title' => 'Hello World',
                    'price_amount' => 100,
                    'price_currency' => 'USD',
                    'created_at' => '2023-05-11T00:00:00+08:00',
                ],
                WithValueObjectsAndSkipAttribute::create(
                    Id::fromString('9b1deb4d-3b7d-4bad-9bdd-2b0d7b3dcb6d'),
                    PostTitle::fromString('Hello World'),
                    Price::of(100, 'USD'),
                    DateTimeRFC3339::fromString('2023-05-11T00:00:00+08:00'),
                ),
            ],
        ];
    }

    /**
     * @test
     * @dataProvider providesData
     */
    public function shouldHydrate(string $className, array $data, object $expected): void
    {
        $hydrator = new ObjectHydratorUsingReflection(
            propertyHydrators: [
                DateTimeImmutable::class => static fn () => new DateTimeImmutablePropertyHydrator(),
                'string' => static fn () => new DefaultPropertyHydrator(),
                'int' => static fn () => new DefaultPropertyHydrator(),
                'bool' => static fn () => new DefaultPropertyHydrator(),
                'enum' => static fn () => new EnumPropertyHydrator(),
                'object' => static fn () => new ObjectPropertyHydrator(
                    keyFormatter: new KeyFormatterForSnakeCasing(),
                ),
            ],
            keyFormatter: new KeyFormatterForSnakeCasing(),
        );

        $object = $hydrator->hydrate($className, $data);

        Assert::assertObjectEquals($expected, $object, 'isEqualTo');
    }
}
