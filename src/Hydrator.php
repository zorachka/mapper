<?php

declare(strict_types=1);

namespace Zorachka\Mapper;

use ReflectionClass;
use ReflectionException;

final class Hydrator
{
    /**
     * @var array<string, ReflectionClass>
     */
    private array $reflectionClassMap;

    /**
     * @throws ReflectionException
     */
    public function hydrate(string $className, array $data): object
    {
        $reflection = $this->getReflectionClassInstance($className);
        $target = $reflection->newInstanceWithoutConstructor();

        foreach ($data as $name => $value) {
            $property = $reflection->getProperty($name);
            if ($property->isPrivate() || $property->isProtected()) {
                $property->setAccessible(true);
            }
            $property->setValue($target, $value);
        }

        return $target;
    }

    /**
     * @param string $className
     * @return ReflectionClass
     * @throws ReflectionException
     */
    private function getReflectionClassInstance(string $className): ReflectionClass
    {
        if (!isset($this->reflectionClassMap[$className])) {
            $this->reflectionClassMap[$className] = new ReflectionClass($className);
        }

        return $this->reflectionClassMap[$className];
    }
}
