<?php

declare(strict_types=1);

namespace Zorachka\Framework\Mapper\Generic;

use Zorachka\Framework\Mapper\EntityId;

/**
 * @template T
 */
final class GenericRepository
{
    /**
     * @var string
     */
    private string $entityClassName;

    /**
     * @param class-string $entityClassName
     */
    public function __construct(string $entityClassName)
    {
        $this->entityClassName = $entityClassName;
    }

    public function nextIdentity(): EntityId
    {
        return GenericEntityId::fromString('');
    }

    public function getById(EntityId $id):
    {

    }
}
