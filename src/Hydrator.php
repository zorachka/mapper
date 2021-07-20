<?php

declare(strict_types=1);

namespace Zorachka\Mapper;

use Closure;
use ReflectionException;
use ReflectionNamedType;
use RuntimeException;
use function sprintf;

final class Hydrator
{
    private ReflectionMap $reflectionMap;

    public function __construct()
    {
        $this->reflectionMap = new ReflectionMap();
    }

    /**
     * Hydrate $object with the provided $data.
     * @param class-string $className
     * @param array $data
     * @return object
     * @throws ReflectionException
     */
    public function hydrate(string $className, array $data): object
    {
        $mapper = new DatabaseMapper($data);

        $target = $this->reflectionMap->getTargetInstance($className);
        $reflectionProperties = $this->reflectionMap->getReflectionProperties($className);

        foreach ($data as $name => $value) {
            if (! isset($reflectionProperties[$name])) {
                throw new ReflectionException(sprintf('Property "%s" doesn\'t exists', $name));
            }

            $reflectionProperty = $reflectionProperties[$name];

            if (! $reflectionProperty->hasType()) {
                throw new RuntimeException('Property must have a type for hydration');
            }

            /** @var ReflectionNamedType $reflectionPropertyType */
            $reflectionPropertyType = $reflectionProperty->getType();

            if ($reflectionPropertyType->isBuiltin()) {
                $handlers = [
                    'string' => fn () => $reflectionProperty->setValue(
                        $target,
                        $mapper->getNonEmptyStringOrNull($name)
                    ),
                    'bool' => fn () => $reflectionProperty->setValue(
                        $target,
                        $mapper->getBooleanOrNull($name)
                    ),
                    'int' => fn () => $reflectionProperty->setValue(
                        $target,
                        $mapper->getIntOrNull($name)
                    ),
                    'default' => fn () => $reflectionProperty->setValue($target, $value),
                ];

                $reflectionPropertyTypeName = $reflectionPropertyType->getName();

                $handler = $handlers[$reflectionPropertyTypeName] ?? $handlers['default'];

                $handler();
            }
        }

        return $target;
    }

    /**
     * Extract values from an object
     * @param object $object
     * @param array<string> $not
     * @return array
     * @throws ReflectionException
     */
    public function extract(object $object, array $not = []): array
    {
        $data = [];
        $className = $object::class;
        foreach ($this->reflectionMap->getReflectionProperties($className) as $property) {
            $propertyName = $property->getName();
            $value = $property->getValue($object);

            if (! empty($not)) {
                if (! in_array($propertyName, $not)) {
                    $data[$propertyName] = $value;
                }
            } else {
                $data[$propertyName] = $value;
            }
        }

        return $data;
    }
}
