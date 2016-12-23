<?php

namespace AshleyDawson\DomainEventDispatcher\EventStorage;

/**
 * Interface EventStoreInterface
 *
 * @package AshleyDawson\DomainEventDispatcher\EventStorage
 */
interface EventStoreInterface
{
    /**
     * Append an event to the event store
     *
     * @param object $event
     * @return void
     */
    public function append($event);
}
