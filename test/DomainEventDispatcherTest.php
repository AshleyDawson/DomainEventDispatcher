<?php

namespace AshleyDawson\DomainEventDispatcher\Test;

use AshleyDawson\DomainEventDispatcher\DomainEventDispatcher;
use AshleyDawson\DomainEventDispatcher\Test\Dummy\InvalidEventListenerNoInvoke;
use AshleyDawson\DomainEventDispatcher\Test\Dummy\InvalidEventListenerTooManyArguments;
use AshleyDawson\DomainEventDispatcher\Test\Dummy\ValidEvent;
use AshleyDawson\DomainEventDispatcher\Test\Dummy\ValidEventTwo;
use AshleyDawson\DomainEventDispatcher\Test\Dummy\ValidGeneralEventListener;
use AshleyDawson\DomainEventDispatcher\Test\Dummy\ValidTypedEventListener;
use AshleyDawson\DomainEventDispatcher\Test\Dummy\ValidTypedEventListenerTwo;

/**
 * Class DomainEventDispatcherTest
 *
 * @package AshleyDawson\DomainEventDispatcher\Test
 */
class DomainEventDispatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function confirm_singleton()
    {
        $this->assertEquals(
            spl_object_hash(DomainEventDispatcher::getInstance()),
            spl_object_hash(DomainEventDispatcher::getInstance())
        );
    }

    /**
     * @test
     */
    public function add_valid_typed_listener()
    {
        DomainEventDispatcher::getInstance()->addListener(
            new ValidTypedEventListener()
        );

        $this->assertCount(1, $this->getDispatcherTypedListeners());
        $this->assertCount(0, $this->getDispatcherGeneralListeners());
    }

    /**
     * @test
     */
    public function add_valid_general_listener()
    {
        DomainEventDispatcher::getInstance()->addListener(
            new ValidGeneralEventListener()
        );

        $this->assertCount(0, $this->getDispatcherTypedListeners());
        $this->assertCount(1, $this->getDispatcherGeneralListeners());
    }

    /**
     * @test
     */
    public function add_valid_general_and_typed_listeners()
    {
        DomainEventDispatcher::getInstance()->addListener(
            new ValidGeneralEventListener()
        );

        DomainEventDispatcher::getInstance()->addListener(
            new ValidTypedEventListener()
        );

        $this->assertCount(1, $this->getDispatcherTypedListeners());
        $this->assertCount(1, $this->getDispatcherGeneralListeners());
    }

    /**
     * @test
     */
    public function add_invalid_listener_with_no_invoke_method()
    {
        $this->setExpectedExceptionRegExp(
            \InvalidArgumentException::class,
            '/__invoke\(.*\) method cannot be found/'
        );

        DomainEventDispatcher::getInstance()->addListener(
            new InvalidEventListenerNoInvoke()
        );
    }

    /**
     * @test
     */
    public function add_invalid_listener_with_too_many_arguments()
    {
        $this->setExpectedExceptionRegExp(
            \InvalidArgumentException::class,
            '/__invoke\(\) method must have only one argument /'
        );

        DomainEventDispatcher::getInstance()->addListener(
            new InvalidEventListenerTooManyArguments()
        );
    }

    /**
     * @test
     */
    public function dispatch_typed_event()
    {
        DomainEventDispatcher::getInstance()->addListener(
            new ValidTypedEventListener()
        );

        DomainEventDispatcher::getInstance()->dispatch(
            new ValidEvent()
        );

        $this->assertEquals(1, InvocationRegister::getInvocationCount(ValidTypedEventListener::class));
    }

    /**
     * @test
     */
    public function dispatch_general_event()
    {
        DomainEventDispatcher::getInstance()->addListener(
            new ValidGeneralEventListener()
        );

        DomainEventDispatcher::getInstance()->dispatch(
            new ValidEvent()
        );

        $this->assertEquals(1, InvocationRegister::getInvocationCount(ValidGeneralEventListener::class));
    }

    /**
     * @test
     */
    public function dispatch_deferred_typed_event()
    {
        DomainEventDispatcher::getInstance()->addListener(
            new ValidTypedEventListener()
        );

        DomainEventDispatcher::getInstance()->defer(
            new ValidEvent()
        );

        $this->assertEquals(0, InvocationRegister::getInvocationCount(ValidTypedEventListener::class));

        DomainEventDispatcher::getInstance()->dispatchDeferred();

        $this->assertEquals(1, InvocationRegister::getInvocationCount(ValidTypedEventListener::class));
    }

    /**
     * @test
     */
    public function dispatch_deferred_general_event()
    {
        DomainEventDispatcher::getInstance()->addListener(
            new ValidGeneralEventListener()
        );

        DomainEventDispatcher::getInstance()->defer(
            new ValidEvent()
        );

        $this->assertEquals(0, InvocationRegister::getInvocationCount(ValidGeneralEventListener::class));

        DomainEventDispatcher::getInstance()->dispatchDeferred();

        $this->assertEquals(1, InvocationRegister::getInvocationCount(ValidGeneralEventListener::class));
    }

    /**
     * @test
     */
    public function dispatch_typed_and_general_events()
    {
        DomainEventDispatcher::getInstance()->addListener(
            new ValidTypedEventListener()
        );

        DomainEventDispatcher::getInstance()->addListener(
            new ValidGeneralEventListener()
        );

        DomainEventDispatcher::getInstance()->dispatch(
            new ValidEvent()
        );

        $this->assertEquals(1, InvocationRegister::getInvocationCount(ValidTypedEventListener::class));
        $this->assertEquals(1, InvocationRegister::getInvocationCount(ValidGeneralEventListener::class));
    }

    /**
     * @test
     */
    public function defer_typed_and_general_events()
    {
        DomainEventDispatcher::getInstance()->addListener(
            new ValidTypedEventListener()
        );

        DomainEventDispatcher::getInstance()->addListener(
            new ValidGeneralEventListener()
        );

        DomainEventDispatcher::getInstance()->defer(
            new ValidEvent()
        );

        $this->assertEquals(0, InvocationRegister::getInvocationCount(ValidTypedEventListener::class));
        $this->assertEquals(0, InvocationRegister::getInvocationCount(ValidGeneralEventListener::class));

        DomainEventDispatcher::getInstance()->dispatchDeferred();

        $this->assertEquals(1, InvocationRegister::getInvocationCount(ValidTypedEventListener::class));
        $this->assertEquals(1, InvocationRegister::getInvocationCount(ValidGeneralEventListener::class));
    }

    /**
     * @test
     */
    public function dispatch_and_defer_typed_events()
    {
        DomainEventDispatcher::getInstance()->addListener(
            new ValidTypedEventListener()
        );

        DomainEventDispatcher::getInstance()->dispatch(
            new ValidEvent()
        );

        DomainEventDispatcher::getInstance()->defer(
            new ValidEvent()
        );

        $this->assertEquals(1, InvocationRegister::getInvocationCount(ValidTypedEventListener::class));

        DomainEventDispatcher::getInstance()->dispatchDeferred();

        $this->assertEquals(2, InvocationRegister::getInvocationCount(ValidTypedEventListener::class));
    }

    /**
     * @test
     */
    public function dispatch_and_defer_general_events()
    {
        DomainEventDispatcher::getInstance()->addListener(
            new ValidTypedEventListener()
        );

        DomainEventDispatcher::getInstance()->dispatch(
            new ValidEvent()
        );

        DomainEventDispatcher::getInstance()->defer(
            new ValidEvent()
        );

        $this->assertEquals(1, InvocationRegister::getInvocationCount(ValidTypedEventListener::class));

        DomainEventDispatcher::getInstance()->dispatchDeferred();

        $this->assertEquals(2, InvocationRegister::getInvocationCount(ValidTypedEventListener::class));
    }

    /**
     * @test
     */
    public function dispatch_mixture_of_typed_events()
    {
        DomainEventDispatcher::getInstance()->addListener(
            new ValidTypedEventListener()
        );

        DomainEventDispatcher::getInstance()->addListener(
            new ValidTypedEventListenerTwo()
        );

        DomainEventDispatcher::getInstance()->dispatch(
            new ValidEvent()
        );

        DomainEventDispatcher::getInstance()->dispatch(
            new ValidEventTwo()
        );

        $this->assertEquals(1, InvocationRegister::getInvocationCount(ValidTypedEventListener::class));
        $this->assertEquals(1, InvocationRegister::getInvocationCount(ValidTypedEventListenerTwo::class));
    }

    /**
     * @test
     */
    public function defer_mixture_of_typed_events()
    {
        DomainEventDispatcher::getInstance()->addListener(
            new ValidTypedEventListener()
        );

        DomainEventDispatcher::getInstance()->addListener(
            new ValidTypedEventListenerTwo()
        );

        DomainEventDispatcher::getInstance()->defer(
            new ValidEvent()
        );

        DomainEventDispatcher::getInstance()->defer(
            new ValidEventTwo()
        );

        $this->assertEquals(0, InvocationRegister::getInvocationCount(ValidTypedEventListener::class));
        $this->assertEquals(0, InvocationRegister::getInvocationCount(ValidTypedEventListenerTwo::class));

        DomainEventDispatcher::getInstance()->dispatchDeferred();

        $this->assertEquals(1, InvocationRegister::getInvocationCount(ValidTypedEventListener::class));
        $this->assertEquals(1, InvocationRegister::getInvocationCount(ValidTypedEventListenerTwo::class));
    }

    /**
     * @test
     */
    public function dispatch_and_defer_mixture_of_typed_events()
    {
        DomainEventDispatcher::getInstance()->addListener(
            new ValidTypedEventListener()
        );

        DomainEventDispatcher::getInstance()->addListener(
            new ValidTypedEventListenerTwo()
        );

        DomainEventDispatcher::getInstance()->dispatch(
            new ValidEvent()
        );

        DomainEventDispatcher::getInstance()->defer(
            new ValidEventTwo()
        );

        $this->assertEquals(1, InvocationRegister::getInvocationCount(ValidTypedEventListener::class));
        $this->assertEquals(0, InvocationRegister::getInvocationCount(ValidTypedEventListenerTwo::class));

        DomainEventDispatcher::getInstance()->dispatchDeferred();

        $this->assertEquals(1, InvocationRegister::getInvocationCount(ValidTypedEventListener::class));
        $this->assertEquals(1, InvocationRegister::getInvocationCount(ValidTypedEventListenerTwo::class));
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        DomainEventDispatcher::destroy();
        InvocationRegister::clear();
    }

    /**
     * Get typed listeners rom dispatcher
     *
     * @return array
     */
    private function getDispatcherTypedListeners()
    {
        $listeners = [];
        foreach ($this->getDispatcherListeners() as list ($type, $listener)) {
            if ($type) {
                $listeners[] = $listener;
            }
        }

        return $listeners;
    }

    /**
     * Get general listeners rom dispatcher
     *
     * @return array
     */
    private function getDispatcherGeneralListeners()
    {
        $listeners = [];
        foreach ($this->getDispatcherListeners() as list ($type, $listener)) {
            if (! $type) {
                $listeners[] = $listener;
            }
        }

        return $listeners;
    }

    /**
     * Get dispatcher listeners
     *
     * @return array
     */
    private function getDispatcherListeners()
    {
        $listenersProperty = (new \ReflectionObject(DomainEventDispatcher::getInstance()))
            ->getProperty('listeners');

        $listenersProperty->setAccessible(true);
        $listeners = $listenersProperty->getValue(DomainEventDispatcher::getInstance());
        $listenersProperty->setAccessible(false);

        return $listeners;
    }
}
