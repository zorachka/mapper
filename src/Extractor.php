<?php

declare(strict_types=1);

namespace Zorachka\Mapper;

use ReflectionClass;
use ReflectionException;

final class Extractor
{
    /**
     * @var array<string, ReflectionClass>
     */
    private array $reflectionClassMap;

    /**
     * @param object $object
     * @param array $fields
     * @return array<string, mixed>
     * @throws ReflectionException
     */
    public function extract(object $object, array $fields): array
    {
        $reflection = $this->getReflectionClassInstance(get_class($object));
        $result = [];

        foreach ($fields as $name) {
            $property = $reflection->getProperty($name);
            if ($property->isPrivate() || $property->isProtected()) {
                $property->setAccessible(true);
            }
            $result[$property->getName()] = $property->getValue($object);
        }

        return $result;
    }

    /**
     * @param string $className
     * @return ReflectionClass
     * @throws ReflectionException
     */
    private function getReflectionClassInstance(string $className): ReflectionClass
    {
        if (! isset($this->reflectionClassMap[$className])) {
            $this->reflectionClassMap[$className] = new ReflectionClass($className);
        }

        return $this->reflectionClassMap[$className];
    }
}
