<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Hydrators;

use Zorachka\Mapper\Hydrator;
use Zorachka\Mapper\PropertyHydrator;

final class DefaultPropertyHydrator implements PropertyHydrator
{
    public function hydrate(mixed $value, string $className, string $keyName, Hydrator $hydrator): mixed
    {
        return $value[$keyName];
    }
}
