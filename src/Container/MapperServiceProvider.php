<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Container;

use DateTimeImmutable;
use Psr\Container\ContainerInterface;
use Zorachka\Container\ServiceProvider;
use Zorachka\Mapper\Hydrator;
use Zorachka\Mapper\Hydrators\DateTimeImmutablePropertyHydrator;
use Zorachka\Mapper\Hydrators\DefaultPropertyHydrator;
use Zorachka\Mapper\Hydrators\EnumPropertyHydrator;
use Zorachka\Mapper\Hydrators\ObjectHydratorUsingReflection;
use Zorachka\Mapper\Hydrators\ObjectPropertyHydrator;
use Zorachka\Mapper\KeyFormatter;
use Zorachka\Mapper\KeyFormatters\KeyFormatterForSnakeCasing;
use Zorachka\Mapper\Serializer;
use Zorachka\Mapper\Serializers\DateTimeImmutablePropertySerializer;
use Zorachka\Mapper\Serializers\DefaultPropertySerializer;
use Zorachka\Mapper\Serializers\EnumPropertySerializer;
use Zorachka\Mapper\Serializers\ObjectPropertySerializer;
use Zorachka\Mapper\Serializers\ObjectSerializerUsingReflection;

final class MapperServiceProvider implements ServiceProvider
{
    public static function getDefinitions(): array
    {
        return [
            Hydrator::class => static function (ContainerInterface $container) {
                /** @var HydratorConfig $config */
                $config = $container->get(HydratorConfig::class);

                /** @var KeyFormatter $keyFormatter */
                $keyFormatter = $container->get($config->keyFormatter());

                return new ObjectHydratorUsingReflection(
                    propertyHydrators: $config->propertyHydrators(),
                    keyFormatter: $keyFormatter,
                );
            },
            Serializer::class => static function (ContainerInterface $container) {
                /** @var SerializerConfig $config */
                $config = $container->get(SerializerConfig::class);

                /** @var KeyFormatter $keyFormatter */
                $keyFormatter = $container->get($config->keyFormatter());

                return new ObjectSerializerUsingReflection(
                    propertySerializers: $config->propertySerializers(),
                    keyFormatter: $keyFormatter,
                );
            },
            HydratorConfig::class => static fn () => HydratorConfig::withDefaults(
                propertyHydrators: [
                    DateTimeImmutable::class => static fn () => new DateTimeImmutablePropertyHydrator(),
                    'string' => static fn () => new DefaultPropertyHydrator(),
                    'int' => static fn () => new DefaultPropertyHydrator(),
                    'bool' => static fn () => new DefaultPropertyHydrator(),
                    'enum' => static fn () => new EnumPropertyHydrator(),
                    'object' => static fn () => new ObjectPropertyHydrator(
                        keyFormatter: new KeyFormatterForSnakeCasing(),
                    ),
                ]
            ),
            SerializerConfig::class => static fn () => SerializerConfig::withDefaults(
                propertySerializers: [
                    DateTimeImmutable::class => static fn () => new DateTimeImmutablePropertySerializer(),
                    'string' => static fn () => new DefaultPropertySerializer(),
                    'int' => static fn () => new DefaultPropertySerializer(),
                    'bool' => static fn () => new DefaultPropertySerializer(),
                    'enum' => static fn () => new EnumPropertySerializer(),
                    'object' => static fn () => new ObjectPropertySerializer(),
                ]
            ),
        ];
    }

    public static function getExtensions(): array
    {
        return [];
    }
}
