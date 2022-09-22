<?php

declare(strict_types=1);

use Spiral\Attributes\AttributeReader;
use Zorachka\Framework\Mapper\Mapper;
use Zorachka\Framework\Tests\Datasets\User;

test('Mapper sh', function () {
    $attributeReader = new AttributeReader();
    $mapper = new Mapper($attributeReader);

    $state = $mapper->state(new User(
        'string', 0, true, new DateTimeImmutable(),
    ));

    var_dump($state);
    die();
});
