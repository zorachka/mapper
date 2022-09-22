<?php

declare(strict_types=1);

namespace Zorachka\Framework\Mapper;

trait EntityBehaviour
{
    private bool $isNew = true;

    private function isNew(): bool
    {
        return $this->isNew;
    }

    private function markAsPersisted(): void
    {
        $this->isNew = false;
    }
}
