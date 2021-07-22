<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Tests\Aggregate;

final class Entity
{
    private EntityId $id;

    private function __construct()
    {
    }

    public function create(EntityId $id): self
    {
        $self = new self();
        $self->id = $id;

        return $self;
    }
}
