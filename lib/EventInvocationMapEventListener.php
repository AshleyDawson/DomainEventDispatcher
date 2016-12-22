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
     * @var bool
     */
    private $isTyped = false;

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
     * @param bool $isTyped
     * @param object $listener
     * @param mixed $executionTimeInMicroseconds
     */
    public function __construct($isTyped, $listener, $executionTimeInMicroseconds)
    {
        $this->listener = $listener;
        $this->executionTimeInMicroseconds = $executionTimeInMicroseconds;
        $this->isTyped = $isTyped;
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

    /**
     * Get isTyped
     *
     * @return boolean
     */
    public function getIsTyped()
    {
        return $this->isTyped;
    }
}
