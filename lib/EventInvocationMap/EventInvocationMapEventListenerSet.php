<?php

namespace AshleyDawson\DomainEventDispatcher\EventInvocationMap;

/**
 * Class EventInvocationMapEventListenerSet
 *
 * @package AshleyDawson\DomainEventDispatcher\EventInvocationMap
 */
class EventInvocationMapEventListenerSet
{
    /**
     * Disposition types
     */
    const DISPOSITION_IMMEDIATE = 'immediate';
    const DISPOSITION_DEFERRED = 'deferred';

    /**
     * @var string
     */
    private $disposition;

    /**
     * @var object
     */
    private $event;

    /**
     * @var EventInvocationMapEventListener[]
     */
    private $listeners = [];

    /**
     * Constructor
     *
     * @param bool $isDeferred
     * @param object $event
     */
    public function __construct($isDeferred, $event)
    {
        $this->event = $event;
        $this->listeners = [];

        $this->disposition = $isDeferred
            ? self::DISPOSITION_DEFERRED
            : self::DISPOSITION_IMMEDIATE;
    }

    /**
     * Add listener
     *
     * @param EventInvocationMapEventListener $listener
     */
    public function addListener(EventInvocationMapEventListener $listener)
    {
        $this->listeners[] = $listener;
    }

    /**
     * Get disposition
     *
     * @return string
     */
    public function getDisposition()
    {
        return $this->disposition;
    }

    /**
     * Get event
     *
     * @return object
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Get listeners
     *
     * @return object[]
     */
    public function getListeners()
    {
        return $this->listeners;
    }
}
