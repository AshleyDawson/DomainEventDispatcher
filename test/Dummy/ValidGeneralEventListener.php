<?php

namespace AshleyDawson\DomainEventDispatcher\Test\Dummy;

use AshleyDawson\DomainEventDispatcher\Test\InvocationRegister;

/**
 * Class ValidGeneralEventListener
 *
 * @package AshleyDawson\DomainEventDispatcher\Test\Dummy
 */
class ValidGeneralEventListener
{
    public function __invoke($event)
    {
        InvocationRegister::registerInvoke($this);
    }
}
