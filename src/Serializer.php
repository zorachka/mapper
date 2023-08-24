<?php

declare(strict_types=1);

namespace Zorachka\Mapper;

interface Serializer
{
    public function serialize(object $object): array;
}
