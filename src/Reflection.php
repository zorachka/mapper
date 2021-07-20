<?php

declare(strict_types=1);

namespace Zorachka\Mapper;

use ReflectionAttribute;
use ReflectionProperty;

final class Reflection
{
    private object $target;
    /**
     * @var array<string, ReflectionProperty>
     */
    private array $properties;
    /**
     * @var array<string, ReflectionAttribute[]>|null
     */
    private ?array $attributes;

    public function __construct(object $target, array $properties, array $attributes = null)
    {
        $this->target = $target;
        $this->properties = $properties;
        $this->attributes = $attributes;
    }

    /**
     * @return object
     */
    public function target(): object
    {
        return $this->target;
    }

    /**
     * @return array<string, ReflectionProperty>
     */
    public function properties(): array
    {
        return $this->properties;
    }

    /**
     * @return array<string, ReflectionAttribute[]>|null
     */
    public function attributes(): ?array
    {
        return $this->attributes;
    }
}
