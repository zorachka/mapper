<?php

declare(strict_types=1);

namespace Zorachka\Framework\Mapper\Generic;

final class GenericEntity
{
    private string $tableName;
    private array $data;

    public function __construct(string $tableName, array $data)
    {
        $this->tableName = $tableName;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
