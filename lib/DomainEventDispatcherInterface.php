<?php

namespace AshleyDawson\DomainEventDispatcher;

/**
 * Interface DomainEventDispatcherInterface
 *
 * @package AshleyDawson\DomainEventDispatcher
 */
interface DomainEventDispatcherInterface
{
    /**
     * Add listener to dispatcher
     *
     * @param object $listener
     */
    public function addListener($listener);

    /**
     * Dispatch an event immediately
     *
     * @param object $event
     */
    public function dispatch($event);

    /**
     * Defer an event to run later in the application
     *
     * @param object $event
     */
    public function defer($event);

    /**
     * Dispatch the deferred events
     */
    public function dispatchDeferred();

    /**
     * Get the event invocation map detailing which listeners were invoked
     * against each event
     *
     * @return EventInvocationMap
     */
    public function getEventInvocationMap();
}
