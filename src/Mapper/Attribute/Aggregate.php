<?php

declare(strict_types=1);

namespace Zorachka\Framework\Mapper\Attribute;

use Attribute;
use Webmozart\Assert\Assert;

#[Attribute(Attribute::TARGET_CLASS)]
final class Aggregate
{
    private ?string $tableName;

    /**
     * Aggregate constructor.
     * @param class-string|null $tableName
     */
    public function __construct(string $tableName = null)
    {
        if ($tableName !== null) {
            Assert::notEmpty($tableName);
        }
        $this->tableName = $tableName;
    }

    /**
     * @return class-string|null
     */
    public function tableName(): ?string
    {
        return $this->tableName;
    }
}
