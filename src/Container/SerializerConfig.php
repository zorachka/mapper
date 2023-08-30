<?php

declare(strict_types=1);

namespace Zorachka\Mapper\Container;

use DateTimeImmutable;
use Zorachka\Mapper\KeyFormatters\KeyFormatterForSnakeCasing;
use Zorachka\Mapper\Serializers\DateTimeImmutablePropertySerializer;
use Zorachka\Mapper\Serializers\DefaultPropertySerializer;
use Zorachka\Mapper\Serializers\EnumPropertySerializer;
use Zorachka\Mapper\Serializers\ObjectPropertySerializer;

final class SerializerConfig
{
    public function __construct(
        /**
         * @var array<string, callable>
         */
        private array $propertySerializers,
        /**
         * @var class-string
         */
        private string $keyFormatter,
    ) {
    }

    /**
     * @param array<string, callable> $propertySerializers
     * @param class-string $keyFormatterClassName
     */
    public static function withDefaults(
        array $propertySerializers = [
            DateTimeImmutable::class => static fn () => new DateTimeImmutablePropertySerializer(),
            'string' => static fn () => new DefaultPropertySerializer(),
            'int' => static fn () => new DefaultPropertySerializer(),
            'bool' => static fn () => new DefaultPropertySerializer(),
            'enum' => static fn () => new EnumPropertySerializer(),
            'object' => static fn () => new ObjectPropertySerializer(),
        ],
        string $keyFormatterClassName = KeyFormatterForSnakeCasing::class,
    ): self {
        return new self($propertySerializers, $keyFormatterClassName);
    }

    /**
     * @return array<string, callable>
     */
    public function propertySerializers(): array
    {
        return $this->propertySerializers;
    }

    public function withPropertyHydrator(string $typeName, callable $propertyHydrator): self
    {
        $new = clone $this;
        $new->propertySerializers[$typeName] = $propertyHydrator;

        return $new;
    }

    public function keyFormatter(): string
    {
        return $this->keyFormatter;
    }

    /**
     * @param class-string $keyFormatterClassName
     * @return $this
     */
    public function withKeyFormatter(string $keyFormatterClassName): self
    {
        $new = clone $this;
        $new->keyFormatter = $keyFormatterClassName;

        return $new;
    }
}
