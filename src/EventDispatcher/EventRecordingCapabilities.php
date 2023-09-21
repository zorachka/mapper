<?php

declare(strict_types=1);

namespace Zorachka\Mapper\EventDispatcher;

use Zorachka\Mapper\Attributes\Skip;

trait EventRecordingCapabilities
{
    /**
     * Array of events to dispatch.
     * @var object[]
     */
    #[Skip]
    private array $events = [];

    /**
     * Register that event was created.
     */
    private function registerThat(object $event): void
    {
        $this->events[] = $event;
    }

    /**
     * Release array of events.
     * @return object[]
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
