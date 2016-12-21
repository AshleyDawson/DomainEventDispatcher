<?php

namespace AshleyDawson\DomainEventDispatcher\Test;

/**
 * Class InvocationRegister
 *
 * @package AshleyDawson\DomainEventDispatcher\Test
 */
class InvocationRegister
{
    /**
     * @var array
     */
    private static $eventInvocations = [];

    /**
     * Register an invocation
     *
     * @param object $listener
     */
    public static function registerInvoke($listener)
    {
        $listenerClass = get_class($listener);

        if (! isset(self::$eventInvocations[$listenerClass])) {
            self::$eventInvocations[$listenerClass] = 1;
        } else {
            self::$eventInvocations[$listenerClass] ++;
        }
    }

    /**
     * Gte invocation count for listener class
     *
     * @param string $listenerClass
     * @return int
     */
    public static function getInvocationCount($listenerClass)
    {
        return isset(self::$eventInvocations[$listenerClass])
            ? self::$eventInvocations[$listenerClass]
            : 0;
    }

    /**
     * Clear invocation register
     */
    public static function clear()
    {
        self::$eventInvocations = [];
    }
}
