<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Container;

use Psr\Container\ContainerInterface;
use Zorachka\Container\ServiceProvider;
use Zorachka\Mapper\Hydrator;
use Zorachka\Mapper\Hydrators\ObjectHydratorUsingReflection;
use Zorachka\Mapper\KeyFormatter;
use Zorachka\Mapper\Serializer;
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
            HydratorConfig::class => static fn () => HydratorConfig::withDefaults(),
            SerializerConfig::class => static fn () => SerializerConfig::withDefaults(),
        ];
    }

    public static function getExtensions(): array
    {
        return [];
    }
}
