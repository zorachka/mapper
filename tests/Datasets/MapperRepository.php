<?php

declare(strict_types=1);

namespace Zorachka\Framework\Tests\Datasets;

use Zorachka\Framework\Mapper\Entity;
use Zorachka\Framework\Mapper\EntityId;
use Zorachka\Framework\Mapper\Mapper;

final class MapperRepository implements Repository
{
    private Mapper $mapper;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function nextIdentity(): EntityId
    {
    }

    public function getById(EntityId $id): User
    {
        $data = [];

        return $this->mapper->fromState($data, User::class);
    }

    public function save(Entity $entity): void
    {
        $generic = $this->mapper->state($entity);
        $tableName = $generic->getTableName();
        $data = $generic->getData();
    }
}
