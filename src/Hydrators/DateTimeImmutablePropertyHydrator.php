<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Hydrators;

use DateTimeImmutable;
use Zorachka\Mapper\Hydrator;
use Zorachka\Mapper\PropertyHydrator;

final class DateTimeImmutablePropertyHydrator implements PropertyHydrator
{
    public function __construct(private readonly string $format = 'Y-m-d H:i:s')
    {
    }

    public function hydrate(mixed $value, string $className, string $keyName, Hydrator $hydrator): mixed
    {
        return DateTimeImmutable::createFromFormat($this->format, $value[$keyName]);
    }
}
