<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Serializers;

use Zorachka\Mapper\PropertySerializer;
use Zorachka\Mapper\Serializer;

final class ObjectPropertySerializer implements PropertySerializer
{
    public function serialize(mixed $value, Serializer $serializer): mixed
    {
        $data = $serializer->serialize($value);

        if (\count($data) > 1) {
            return $data;
        }

        return \array_shift($data);
    }
}
