<?php

declare(strict_types=1);

namespace Zorachka\Framework\Tests\Datasets;

use Zorachka\Framework\Mapper\Entity;
use Zorachka\Framework\Mapper\EntityId;

interface Repository
{
    public function nextIdentity(): EntityId;

    public function getById(EntityId $id): Entity;

    public function save(Entity $entity): void;
}
