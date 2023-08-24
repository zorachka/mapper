<?php

declare(strict_types=1);

namespace Zorachka\Mapper;

interface Hydrator
{
    public function hydrate(string $className, array $data): object;
}
