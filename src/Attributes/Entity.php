<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Attributes;

use Attribute;
use Webmozart\Assert\Assert;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Entity
{
    private ?string $className;

    /**
     * Entity constructor.
     * @param class-string|null $className
     */
    public function __construct(string $className = null)
    {
        if ($className !== null) {
            Assert::notEmpty($className);
        }
        $this->className = $className;
    }

    /**
     * @return class-string|null
     */
    public function className(): ?string
    {
        return $this->className;
    }
}
