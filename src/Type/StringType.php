<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Type;

use Zorachka\Mapper\DatabaseMapper;

final class StringType implements CastType
{
    private DatabaseMapper $mapper;

    public function __construct(DatabaseMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function hydrate(string $name, mixed $value): ?string
    {
        return $this->mapper->getNonEmptyStringOrNull($name);
    }

    public function extract()
    {
    }
}
