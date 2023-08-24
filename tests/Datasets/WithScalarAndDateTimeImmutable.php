<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Tests\Datasets;

use DateTimeImmutable;

final class WithScalarAndDateTimeImmutable
{
    public function __construct(
        private readonly string $id,
        private readonly int $status,
        private readonly bool $isAvailable,
        private readonly DateTimeImmutable $createdAt,
    ) {
    }
}
