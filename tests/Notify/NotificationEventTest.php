<?php

namespace Mdojr\SimplePay\Notify;

use PHPUnit\Framework\TestCase;
use Mdojr\SimplePay\Notify\NotificationEvent;


class NotificationEventTest extends TestCase
{

    public function testCanCreateNotifationEvent()
    {
        $event = NotificationEvent::EVENT_PAYMENT_ANY;
        $ne = new NotificationEvent($event);

        $this->assertInstanceOf(NotificationEvent::class, $ne);
        $this->assertEquals($ne, $event);
    }
}