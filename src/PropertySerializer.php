<?php

declare(strict_types=1);

namespace Zorachka\Mapper;

interface PropertySerializer
{
    public function serialize(mixed $value, Serializer $serializer): mixed;
}
