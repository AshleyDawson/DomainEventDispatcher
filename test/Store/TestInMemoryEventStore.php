<?php

namespace AshleyDawson\DomainEventDispatcher\Test\Store;

use AshleyDawson\DomainEventDispatcher\EventStorage\EventStoreInterface;

/**
 * Class TestInMemoryEventStore
 *
 * @package AshleyDawson\DomainEventDispatcher\Test\Store
 */
class TestInMemoryEventStore implements EventStoreInterface
{
    /**
     * @var object[]
     */
    private $events = [];

    /**
     * {@inheritdoc}
     */
    public function append($event)
    {
        $this->events[] = $event;
    }

    /**
     * @return array
     */
    public function getAllEvents()
    {
        return $this->events;
    }
}
