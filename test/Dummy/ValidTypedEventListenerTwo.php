<?php

namespace AshleyDawson\DomainEventDispatcher\Test\Dummy;

use AshleyDawson\DomainEventDispatcher\Test\InvocationRegister;

/**
 * Class ValidTypedEventListenerTwo
 *
 * @package AshleyDawson\DomainEventDispatcher\Test\Dummy
 */
class ValidTypedEventListenerTwo
{
    public function __invoke(ValidEventTwo $event)
    {
        InvocationRegister::registerInvoke($this);
    }
}
