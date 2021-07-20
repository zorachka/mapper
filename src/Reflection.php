<?php

declare(strict_types=1);

namespace Zorachka\Mapper;

use ReflectionProperty;

final class Reflection
{
    private object $target;
    /**
     * @var array<string, ReflectionProperty>
     */
    private array $properties;

    public function __construct(object $target, array $properties)
    {
        $this->target = $target;
        $this->properties = $properties;
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
}
