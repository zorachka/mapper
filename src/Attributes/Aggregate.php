<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Attributes;

use Attribute;
use Webmozart\Assert\Assert;

#[Attribute(Attribute::TARGET_CLASS)]
final class Aggregate
{
    private ?string $tableName;

    public function __construct(string $tableName = null)
    {
        if ($tableName !== null) {
            Assert::notEmpty($tableName);
        }
        $this->tableName = $tableName;
    }

    public function tableName(): ?string
    {
        return $this->tableName;
    }
}
