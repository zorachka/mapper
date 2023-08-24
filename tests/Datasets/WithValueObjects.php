<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Tests\Datasets;

use Zorachka\Mapper\Tests\Datasets\ValueObjects\DateTimeRFC3339;
use Zorachka\Mapper\Tests\Datasets\ValueObjects\Id;
use Zorachka\Mapper\Tests\Datasets\ValueObjects\PostTitle;
use Zorachka\Mapper\Tests\Datasets\ValueObjects\Price;

final class WithValueObjects
{
    private function __construct(
        private readonly Id $id,
        private readonly PostTitle $title,
        private readonly Price $price,
        private readonly DateTimeRFC3339 $createdAt,
    ) {
    }

    public static function create(Id $id, PostTitle $title, Price $price, DateTimeRFC3339 $createdAt): self
    {
        return new self($id, $title, $price, $createdAt);
    }
}
