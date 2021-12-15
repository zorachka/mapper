<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Attributes;

use Attribute;
use Webmozart\Assert\Assert;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Column
{
    private ?string $type;

    public function __construct(string $type = null)
    {
        if ($type !== null) {
            Assert::notEmpty($type);
        }
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function type(): ?string
    {
        return $this->type;
    }
}
