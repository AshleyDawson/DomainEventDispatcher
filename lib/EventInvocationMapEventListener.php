<?php

namespace AshleyDawson\DomainEventDispatcher;

/**
 * Class EventInvocationMapEventListener
 *
 * @package AshleyDawson\DomainEventDispatcher
 */
class EventInvocationMapEventListener
{
    /**
     * @var object
     */
    private $listener;

    /**
     * @var mixed
     */
    private $executionTimeInMicroseconds;

    /**
     * Constructor
     *
     * @param object $listener
     * @param mixed $executionTimeInMicroseconds
     */
    public function __construct($listener, $executionTimeInMicroseconds)
    {
        $this->listener = $listener;
        $this->executionTimeInMicroseconds = $executionTimeInMicroseconds;
    }

    /**
     * Get listener
     *
     * @return object
     */
    public function getListener()
    {
        return $this->listener;
    }

    /**
     * Get executionTimeInMicroseconds
     *
     * @return mixed
     */
    public function getExecutionTimeInMicroseconds()
    {
        return $this->executionTimeInMicroseconds;
    }
}
