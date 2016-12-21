Domain Event Dispatcher
=======================

Singleton domain event dispatcher to be used during [DDD](https://en.wikipedia.org/wiki/Domain-driven_design). The domain 
event dispatcher is a singleton so it can be easily used from within your model.

Installation
------------

Install via Composer using the following command:

```
$ composer require ashleydawson/domain-event-dispatcher
```

Basic Usage
-----------

Define an event to be dispatched. Event classes can be anything, and should be easily serialized.

```php
<?php

namespace Acme\Event;

class MyEvent
{
}
```

Define a listener for the event

```php
<?php

namespace Acme\EventListener;

use Acme\Event\MyEvent;

class MyTypedEventListener
{
    // Domain event listeners must implement the __invoke() magic method with only one argument
    public function __invoke(MyEvent $event)
    {
        // Do something useful here...
    }
}
```

Put it all together, add your listeners and dispatch.

```php
<?php

require __DIR__.'/vendor/autoload.php';

use AshleyDawson\DomainEventDispatcher\DomainEventDispatcher;
use Acme\Event\MyEvent;
use Acme\EventListener\MyTypedEventListener;

// Add your listener to the dispatcher
DomainEventDispatcher::getInstance()->addListener(
    new MyTypedEventListener()
);

// Dispatch the event from within your domain, e.g. from your domain model, etc.
DomainEventDispatcher::getInstance()->dispatch(
    new MyEvent()
);
```

Listener Types
--------------

There are two types of listeners, `general` and `typed`. A `general` listener is invoked by **any** domain event and a
`typed` listener is invoked by events of a corresponding type.

General Listener
-----------------

In a previous example, we saw the event dispatcher used for typed events where the event argument is type hinted in the
`__invoke()` method of the event listener. General listeners are invoked by all events and don't have a type hint. For example:

```php
<?php

namespace Acme\EventListener;

class MyEventGeneralListener
{
    // Event is not type hinted as this is a general event listener - it will be invoked by all events
    public function __invoke($event)
    {
        // Do something useful here...
    }
}
```

Typed Listener
--------------

A typed listener only responds to a particular type of domain event:

```php
<?php

namespace Acme\EventListener;

use Acme\Event\MyEvent;

class MyEventGeneralListener
{
    // This listener will only respond to MyEvent events
    public function __invoke(MyEvent $event)
    {
        // Do something useful here...
    }
}
```

Deferred Events
---------------

Sometimes it might be useful to dispatch events later in the application flow. To do this, events may be deferred and 
dispatched later.

```php
<?php

require __DIR__.'/vendor/autoload.php';

use AshleyDawson\DomainEventDispatcher\DomainEventDispatcher;
use Acme\Event\MyEvent;
use Acme\EventListener\MyTypedEventListener;

// Add your listener to the dispatcher
DomainEventDispatcher::getInstance()->addListener(
    new MyTypedEventListener()
);

// Dispatch the event from within your domain, e.g. from your domain model, etc.
DomainEventDispatcher::getInstance()->defer(
    new MyEvent()
);

// From a different level of the application, dispatch the deferred events
DomainEventDispatcher::getInstance()->dispatchDeferred();
```

Tests
-----

To run the test suite, run the following:

```
$ php bin/phpunit
```