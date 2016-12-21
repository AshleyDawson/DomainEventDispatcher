<?php

namespace AshleyDawson\DomainEventDispatcher;

/**
 * Class DomainEventDispatcher
 *
 * @package AshleyDawson\DomainEventDispatcher
 */
class DomainEventDispatcher implements DomainEventDispatcherInterface
{
    /**
     * @var self
     */
    private static $instance;

    /**
     * @var array
     */
    private $listeners = [];

    /**
     * @var array
     */
    private $deferredEvents = [];

    /**
     * @return self
     */
    public static function getInstance()
    {
        return (self::$instance ?: self::$instance = new self());
    }

    /**
     *
     *Destroy singleton
     */
    public static function destroy()
    {
        self::$instance = null;
    }

    /**
     * {@inheritdoc}
     */
    public function addListener($listener)
    {
        $this->assertValidListener($listener);

        $this->listeners[] = [
            $this->getListenerEventType($listener),
            $listener
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch($event)
    {
        $this->performDispatch(
            $this->getListenersForEvent($event),
            $event
        );
    }

    /**
     * {@inheritdoc}
     */
    public function defer($event)
    {
        $this->deferredEvents[] = $event;
    }

    /**
     * {@inheritdoc}
     */
    public function dispatchDeferred()
    {
        foreach ($this->deferredEvents as $event) {
            $this->performDispatch(
                $this->getListenersForEvent($event),
                $event
            );
        }
    }

    /**
     * Get the listeners for a particular event
     *
     * @param object $event
     * @return array
     */
    protected function getListenersForEvent($event)
    {
        $listeners = [];
        foreach ($this->listeners as list ($type, $listener)) {
            if (null === $type || get_class($event) == $type) {
                $listeners[] = $listener;
            }
        }

        return $listeners;
    }

    /**
     * Dispatch a single event to the collection of listeners
     *
     * @param array $listeners
     * @param object $event
     */
    protected function performDispatch(array $listeners, $event)
    {
        foreach ($listeners as $listener) {
            $listener($event);
        }
    }

    /**
     * Get listener event type
     *
     * @param object $listener
     * @return string|null Where NULL is a general listener (listens to all events)
     */
    protected function getListenerEventType($listener)
    {
        $parameters = (new \ReflectionObject($listener))
            ->getMethod('__invoke')
            ->getParameters();

        if (! isset($parameters[0])) {
            throw new \RuntimeException(sprintf(
                'Domain event listener %s#__invoke() must have one argument',
                get_class($listener)
            ));
        }

        if (! $parameters[0]->getClass()) {
            return null;
        }

        $typeHint = $parameters[0]
            ->getClass()
            ->getName();

        return class_exists($typeHint)
            ? $typeHint
            : null;
    }

    /**
     * Assert valid listener
     *
     * @param object $listener
     */
    protected function assertValidListener($listener)
    {
        if (! is_object($listener)) {
            throw new \InvalidArgumentException(sprintf(
                'Domain event listeners must be objects, %s given',
                gettype($listener)
            ));
        }

        if (! method_exists($listener, '__invoke')) {
            throw new \InvalidArgumentException(sprintf(
                'The %s#__invoke([EventType] $event) method cannot be found, it must be defined for all domain event '
                .'listeners',
                get_class($listener)
            ));
        }

        $numberOfParameters = (new \ReflectionObject($listener))
            ->getMethod('__invoke')
            ->getNumberOfParameters();

        if ($numberOfParameters != 1) {
            throw new \InvalidArgumentException(sprintf(
                'Domain event listener %s#__invoke() method must have only one argument (that of the event to me '
                .'handled), %d arguments defined',
                get_class($listener),
                $numberOfParameters
            ));
        }
    }

    /**
     * Constructor
     */
    final protected function __construct()
    {
    }
}