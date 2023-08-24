<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Tests\Datasets;

use DateTimeImmutable;
use Zorachka\Mapper\Tests\Datasets\ValueObjects\PaymentStatusString;
use Zorachka\Mapper\Tests\Datasets\ValueObjects\PublishedStatusInt;

final class WithScalarAndStatusEnum
{
    public function __construct(
        private readonly string $id,
        private readonly PublishedStatusInt $publishedStatus,
        private readonly PaymentStatusString $paymentStatus,
        private readonly DateTimeImmutable $createdAt,
    ) {
    }
}
