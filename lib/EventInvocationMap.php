<?php

namespace AshleyDawson\DomainEventDispatcher;

/**
 * Class EventInvocationMap
 *
 * Used to map the listeners that have been invoked by events
 *
 * @package AshleyDawson\DomainEventDispatcher
 */
class EventInvocationMap
{
    /**
     * @var array
     */
    private $sets = [];

    /**
     * Add event listener set
     *
     * @param EventInvocationMapEventListenerSet $eventListenerSet
     */
    public function addEventListenerSet(EventInvocationMapEventListenerSet $eventListenerSet)
    {
        $this->sets[] = $eventListenerSet;
    }

    /**
     * Get sets
     *
     * @return EventInvocationMapEventListenerSet[]
     */
    public function getSets()
    {
        return $this->sets;
    }
}
