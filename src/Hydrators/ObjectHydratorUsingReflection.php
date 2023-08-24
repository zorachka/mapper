<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Hydrators;

use Closure;
use ReflectionClass;
use Zorachka\Mapper\Hydrator;
use Zorachka\Mapper\KeyFormatter;

final class ObjectHydratorUsingReflection implements Hydrator
{
    public function __construct(
        private readonly array $propertyHydrators,
        private readonly KeyFormatter $keyFormatter,
    ) {
    }

    private function getPropertyHydrator(mixed $value, string $typeName): Closure
    {
        if (\class_exists($typeName)) {
            $isEnum = \enum_exists($typeName);

            if ($isEnum) {
                return $this->propertyHydrators['enum'];
            }
        }

        return $this->propertyHydrators[$typeName] ?? $this->propertyHydrators['object'];
    }

    public function hydrate(string $className, array $data): object
    {
        $reflectionClass = new ReflectionClass($className);
        $object = $reflectionClass->newInstanceWithoutConstructor();

        $properties = $reflectionClass->getProperties();

        foreach ($properties as $property) {
            $propertyName = $property->getName();

            $keyName = $this->keyFormatter->propertyNameToKey($propertyName);

            $property->setAccessible(true);

            $rawValues = array_filter($data, static fn ($key) => str_starts_with($key, $keyName), ARRAY_FILTER_USE_KEY);

            $rawValue = \count($rawValues) > 0 ? $rawValues : $data[$keyName];
            $typeName = $property->getType()->getName();

            $propertyHydrator = $this->getPropertyHydrator($rawValue, $typeName)();
            $value = $propertyHydrator->hydrate($rawValue, $typeName, $keyName, $this);

            $property->setValue($object, $value);
        }

        return $object;
    }
}
