<?php

declare(strict_types=1);

namespace Zorachka\Mapper;

use DateTimeImmutable;

final class DatabaseMapper
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getString(string $key): string
    {
        if (! isset($this->data[$key])) {
            return '';
        }

        return (string)$this->data[$key];
    }

    public function getInt(string $key): int
    {
        if (! isset($this->data[$key])) {
            return 0;
        }

        return (int)$this->data[$key];
    }

    public function getBoolean(string $key): bool
    {
        if (! isset($this->data[$key])) {
            return false;
        }

        return $this->data[$key] === 1;
    }

    public function getBooleanOrNull(string $key): ?bool
    {
        if (! isset($this->data[$key])) {
            return null;
        }

        if (isset($this->data[$key]) && $this->data[$key] === '') {
            return null;
        }

        return $this->data[$key] === 1;
    }

    public function getIntOrNull(
        string $key
    ): ?int {
        if (! isset($this->data[$key])) {
            return null;
        }

        if (isset($this->data[$key]) && $this->data[$key] === '') {
            return null;
        }

        return (int)$this->data[$key];
    }

    public function getNonEmptyStringOrNull(
        string $key
    ): ?string {
        if (! isset($this->data[$key])) {
            return null;
        }

        if (isset($this->data[$key]) && $this->data[$key] === '') {
            return null;
        }

        return (string)$this->data[$key];
    }

    public function getDateTimeImmutableOrNull(
        string $key,
        string $format = 'Y-m-d H:i:s',
        string $timezone = 'UTC',
    ): ?DateTimeImmutable {
        if (! isset($this->data[$key])) {
            return null;
        }

        if (isset($this->data[$key]) && $this->data[$key] === '') {
            return null;
        }

        return DateTimeImmutable::createFromFormat(
            $format,
            $this->data[$key],
            new \DateTimeZone($timezone)
        );
    }
}
