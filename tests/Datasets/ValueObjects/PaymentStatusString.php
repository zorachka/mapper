<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Tests\Datasets\ValueObjects;

enum PaymentStatusString: string
{
    case PAID = 'paid';
    case UNPAID = 'unpaid';
}
