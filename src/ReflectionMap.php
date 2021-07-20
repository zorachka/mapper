<?php

declare(strict_types=1);

namespace Zorachka\Mapper;

use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

final class ReflectionMap
{
    /**
     * Simple in-memory array cache of ReflectionProperties used.
     * @var array<class-string, Reflection|null>
     */
    private static array $reflectionMap = [];

    /**
     * Get a reflection properties from in-memory cache and lazy-load if
     * class has not been loaded.
     * @param class-string $className
     * @throws ReflectionException
     */
    private static function getReflection(string $className): Reflection
    {
        if (isset(ReflectionMap::$reflectionMap[$className])) {
            return ReflectionMap::$reflectionMap[$className];
        }

        ReflectionMap::$reflectionMap[$className] = null;

        $reflectionClass = new ReflectionClass($className);
        $reflectionProperties = $reflectionClass->getProperties();

        $properties = [];

        foreach ($reflectionProperties as $property) {
            if ($property->isPrivate() || $property->isProtected()) {
                $property->setAccessible(true);
            }
            $properties[$property->getName()] = $property;
        }

        ReflectionMap::$reflectionMap[$className] = new Reflection(
            $reflectionClass->newInstanceWithoutConstructor(),
            $properties,
        );

        return ReflectionMap::$reflectionMap[$className];
    }

    /**
     * @param class-string $className
     * @return array<string, ReflectionProperty>
     * @throws ReflectionException
     */
    public static function getReflectionProperties(string $className): array
    {
        return self::getReflection($className)->properties();
    }

    /**
     * @param class-string $className
     * @return object
     * @throws ReflectionException
     */
    public static function getTargetInstance(string $className): object
    {
        return self::getReflection($className)->target();
    }
}
