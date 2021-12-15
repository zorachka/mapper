<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Tests\Aggregate;

final class AggregateWasCreated
{
    private AggregateId $id;

    private function __construct(AggregateId $id)
    {
        $this->id = $id;
    }

    public static function withId(AggregateId $id): self
    {
        return new AggregateWasCreated($id);
    }

    /**
     * @return AggregateId
     */
    public function id(): AggregateId
    {
        return $this->id;
    }
}
