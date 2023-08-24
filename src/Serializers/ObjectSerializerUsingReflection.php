<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Serializers;

use Closure;
use DateTimeImmutable;
use ReflectionClass;
use ReflectionProperty;
use UnitEnum;
use Zorachka\Mapper\KeyFormatter;
use Zorachka\Mapper\KeyFormatters;
use Zorachka\Mapper\Serializer;
use Zorachka\Mapper\Serializers;

final class ObjectSerializerUsingReflection implements Serializer
{
    private array $propertySerializers;
    private KeyFormatter $keyFormatter;

    public function __construct()
    {
        $this->propertySerializers = [
            DateTimeImmutable::class => static fn () => new Serializers\DateTimeImmutablePropertySerializer(),
            'string' => static fn () => new Serializers\DefaultPropertySerializer(),
            'int' => static fn () => new Serializers\DefaultPropertySerializer(),
            'bool' => static fn () => new Serializers\DefaultPropertySerializer(),
            'enum' => static fn () => new Serializers\EnumPropertySerializer(),
            'object' => static fn () => new Serializers\ObjectPropertySerializer(),
        ];
        $this->keyFormatter = new KeyFormatters\KeyFormatterForSnakeCasing();
    }

    private function getPropertySerializer(mixed $value, string $typeName): Closure
    {
        if (\is_object($value)) {
            $isEnum = \is_a($value, UnitEnum::class, true);

            if ($isEnum) {
                return $this->propertySerializers['enum'];
            }
        }

        return $this->propertySerializers[$typeName] ?? $this->propertySerializers['object'];
    }

    private function getPropertyData(ReflectionProperty $property): array
    {
        return [
            $property->getName(),
            $property->getType()->getName(),
        ];
    }

    public function serialize(object $object): array
    {
        $reflection = new ReflectionClass($object);
        $properties = $reflection->getProperties();

        $payload = [];
        foreach ($properties as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($object);

            [$propertyName, $typeName] = $this->getPropertyData($property);

            $serializer = $this->getPropertySerializer($value, $typeName)();
            $serializedValue = $serializer->serialize($value, $this);

            if (\is_array($serializedValue)) {
                foreach ($serializedValue as $key => $item) {
                    $keyName = $this->keyFormatter->propertyNameToKey($propertyName . ucfirst($key));
                    $payload[$keyName] = $item;
                }

                continue;
            }

            $keyName = $this->keyFormatter->propertyNameToKey($propertyName);
            $payload[$keyName] = $serializedValue;
        }

        return $payload;
    }
}
