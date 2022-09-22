<?php

declare(strict_types=1);

namespace Zorachka\Framework\Mapper;

use ReflectionClass;
use ReflectionProperty;
use Spiral\Attributes\AttributeReader;
use Zorachka\Framework\Mapper\Attribute\Aggregate;
use Zorachka\Framework\Mapper\Attribute\Column;
use Zorachka\Framework\Mapper\Generic\GenericEntity;

final class Mapper
{
    private AttributeReader $attributeReader;

    public function __construct(AttributeReader $attributeReader)
    {
        $this->attributeReader = $attributeReader;
    }

    /**
     * @param array $data
     * @param string $entityClassName
     * @return Entity
     * @throws \ReflectionException
     */
    public function fromState(array $data, string $entityClassName): Entity
    {
        $reflectionClass = new ReflectionClass($entityClassName);

        /** @var Entity $entity */
        $entity = $reflectionClass->newInstanceWithoutConstructor();

        return $entity;
    }

    private function getTableName(ReflectionClass $reflectionClass): string
    {
        $aggregate = $this->attributeReader->firstClassMetadata($reflectionClass, Aggregate::class);
        $tableName = $aggregate->tableName();

        if ($tableName === null) {
            return (string)$reflectionClass::class;
        }

        return $tableName;
    }

    private function getPropertyValue(ReflectionProperty $reflectionProperty): mixed
    {
        $propertyValue = $reflectionProperty->getValue();
        $propertyType = $reflectionProperty->getType();

        return match ($propertyType->getName()) {
            'DateTimeImmutable' => $propertyType->allowsNull() ? $propertyValue->format('Y-m-d H:i:s') : $propertyValue->format('Y-m-d H:i:s'),
            default => $propertyValue
        };
    }

    /**
     * @param Entity $entity
     * @return GenericEntity
     */
    public function state(Entity $entity): GenericEntity
    {
        $reflectionClass = new ReflectionClass($entity);

        $tableName = $this->getTableName($reflectionClass);
        $data = [];

        $reflectionProperties = $reflectionClass->getProperties();
        foreach ($reflectionProperties as $reflectionProperty) {
            $column = $this->attributeReader->firstPropertyMetadata($reflectionProperty, Column::class);

            if ($column === null) {
                continue;
            }

            $propertyName = $reflectionProperty->getName();
            $data[$propertyName] = $this->getPropertyValue($reflectionProperty);
        }

        return new GenericEntity($tableName, $data);
    }
}
