<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Serializers;

use Zorachka\Mapper\PropertySerializer;
use Zorachka\Mapper\Serializer;

final class DefaultPropertySerializer implements PropertySerializer
{
    public function serialize(mixed $value, Serializer $serializer): mixed
    {
        return $value;
    }
}
