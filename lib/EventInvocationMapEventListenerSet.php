<?php

namespace AshleyDawson\DomainEventDispatcher;

/**
 * Class EventInvocationMapEventListenerSet
 *
 * @package AshleyDawson\DomainEventDispatcher
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
     * @var object[]
     */
    private $listeners = [];

    /**
     * Constructor
     *
     * @param bool $isDeferred
     * @param object $event
     * @param \object[] $listeners
     */
    public function __construct($isDeferred, $event, array $listeners)
    {
        $this->event = $event;
        $this->listeners = $listeners;

        $this->disposition = $isDeferred
            ? self::DISPOSITION_DEFERRED
            : self::DISPOSITION_IMMEDIATE;
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
