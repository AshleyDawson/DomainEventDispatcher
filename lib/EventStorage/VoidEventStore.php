<?php

namespace AshleyDawson\DomainEventDispatcher\EventStorage;

/**
 * Class VoidEventStore
 *
 * @package AshleyDawson\DomainEventDispatcher\EventStorage
 */
class VoidEventStore implements EventStoreInterface
{
    /**
     * {@inheritdoc}
     */
    public function append($event)
    {
        // Nothing to do here as this is a void event store
    }
}
