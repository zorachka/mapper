<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Tests\Aggregate;

use DateTimeImmutable;
use Zorachka\EventDispatcher\Domain\EventRecordingCapabilities;
use Zorachka\Mapper\Attributes\Aggregate;
use Zorachka\Mapper\Attributes\Column;
use Zorachka\Mapper\Attributes\Guid;
use Zorachka\Mapper\Attributes\PrimaryKey;

#[Aggregate]
final class GenericAggregate
{
    use EventRecordingCapabilities;

    #[PrimaryKey, Guid]
    private AggregateId $id;

    #[Column]
    private string $string;

    #[Column]
    private int $integer;

    #[Column]
    private bool $boolean;

    #[Column]
    private DateTimeImmutable $dateTime;

    private function __construct(AggregateId $id)
    {
        $this->id = $id;
    }

    public static function create(
        AggregateId $id,
        string $string,
        int $integer,
        bool $boolean,
        DateTimeImmutable $dateTime,
    ): self {
        $self = new self($id);
        $self->string = $string;
        $self->integer = $integer;
        $self->boolean = $boolean;
        $self->dateTime = $dateTime;

        $self->registerThat(AggregateWasCreated::withId($id));

        return $self;
    }

    public function state(): array
    {
        return [
            'id' => $this->id->asString(),
            'string' => $this->string,
            'integer' => $this->integer,
            'boolean' => $this->boolean,
            'dateTime' => $this->dateTime->format('Y-m-d H:i:s'),
        ];
    }
}
