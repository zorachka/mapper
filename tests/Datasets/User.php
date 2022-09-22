<?php

declare(strict_types=1);

namespace Zorachka\Framework\Tests\Datasets;

use DateTimeImmutable;
use Zorachka\Framework\Mapper\Attribute\Aggregate;
use Zorachka\Framework\Mapper\Attribute\Column;
use Zorachka\Framework\Mapper\Entity;

#[Aggregate(tableName: 'users')]
final class User implements Entity
{
    #[Column]
    private string $string;

    #[Column]
    private ?string $stringOrNull;

    #[Column]
    private int $integer;

    #[Column]
    private ?int $integerOrNull;

    #[Column]
    private bool $boolean;

    #[Column]
    private ?bool $booleanOrNull;

    #[Column]
    private DateTimeImmutable $dateTime;

    #[Column]
    private ?DateTimeImmutable $dateTimeOrNull;

    public function __construct(
        string $string,
        ?string $stringOrNull = null,
        int $integer,
        ?int $integerOrNull = null,
        bool $boolean,
        ?bool $booleanOrNull = null,
        DateTimeImmutable $dateTime,
        ?DateTimeImmutable $dateTimeOrNull = null,
    ) {
        $this->string = $string;
        $this->integer = $integer;
        $this->boolean = $boolean;
        $this->dateTime = $dateTime;
        $this->stringOrNull = $stringOrNull;
        $this->integerOrNull = $integerOrNull;
        $this->booleanOrNull = $booleanOrNull;
        $this->dateTimeOrNull = $dateTimeOrNull;
    }
}
