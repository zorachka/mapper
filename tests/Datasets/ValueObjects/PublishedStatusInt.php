<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Tests\Datasets\ValueObjects;

enum PublishedStatusInt: int
{
    case DRAFT = 0;
    case PUBLISHED = 1;
}
