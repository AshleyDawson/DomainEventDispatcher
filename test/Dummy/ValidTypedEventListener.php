<?php

namespace AshleyDawson\DomainEventDispatcher\Test\Dummy;

use AshleyDawson\DomainEventDispatcher\Test\InvocationRegister;

/**
 * Class ValidEventListener
 *
 * @package AshleyDawson\DomainEventDispatcher\Test\Dummy
 */
class ValidTypedEventListener
{
    public function __invoke(ValidEvent $event)
    {
        InvocationRegister::registerInvoke($this);
    }
}
