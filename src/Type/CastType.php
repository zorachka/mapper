<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Type;

interface CastType
{
    public function hydrate(string $name, mixed $value): mixed;
}
