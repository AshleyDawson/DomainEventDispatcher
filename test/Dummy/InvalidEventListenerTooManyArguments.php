<?php

namespace AshleyDawson\DomainEventDispatcher\Test\Dummy;

use AshleyDawson\DomainEventDispatcher\Test\InvocationRegister;

/**
 * Class InvalidEventListenerTooManyArguments
 *
 * @package AshleyDawson\DomainEventDispatcher\Test\Dummy
 */
class InvalidEventListenerTooManyArguments
{
    public function __invoke($arg1, $arg2)
    {
        InvocationRegister::registerInvoke($this);
    }
}
