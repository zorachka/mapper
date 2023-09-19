<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Serializers;

use Closure;
use ReflectionClass;
use ReflectionProperty;
use UnitEnum;
use Zorachka\Mapper\Attributes\Skip;
use Zorachka\Mapper\KeyFormatter;
use Zorachka\Mapper\Serializer;

final class ObjectSerializerUsingReflection implements Serializer
{
    public function __construct(
        private readonly array $propertySerializers,
        private readonly KeyFormatter $keyFormatter,
    ) {
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

    public function serialize(?object $object): array
    {
        if ($object === null) {
            return [];
        }

        $reflection = new ReflectionClass($object);
        $properties = $reflection->getProperties();

        $payload = [];
        foreach ($properties as $property) {
            $attributes = $property->getAttributes(Skip::class);
            if (\count($attributes) > 0) {
                continue;
            }

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
