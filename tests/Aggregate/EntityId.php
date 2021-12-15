<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Tests\Aggregate;

use Webmozart\Assert\Assert;

final class EntityId
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

    public static function nil(): self
    {
        return new self('00000000-0000-0000-0000-000000000000');
    }

    public function asString(): string
    {
        return $this->id;
    }
}
