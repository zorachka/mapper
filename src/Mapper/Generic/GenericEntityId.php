<?php

declare(strict_types=1);

namespace Zorachka\Framework\Mapper\Generic;

use Webmozart\Assert\Assert;
use Zorachka\Framework\Mapper\EntityId;

final class GenericEntityId implements EntityId
{
    private string $id;

    private function __construct(string $id)
    {
        Assert::uuid($id);
        $this->id = $id;
    }

    public static function fromString(string $id): self
    {
        return new self($id);
    }

    public function asString(): string
    {
        return $this->id;
    }
}
