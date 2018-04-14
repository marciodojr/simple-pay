<?php

namespace Mdojr\SimplePay;

use Mdojr\SimplePay\SimpleNotify;
use PHPUnit\Framework\TestCase;
use Moip\Moip;
use Moip\Auth\OAuth;
use Moip\Resource\NotificationPreferencesList;
use Moip\Resource\NotificationPreferences;
use Mdojr\SimplePay\Notify\NotificationEvent;
use Exception;

class SimpleNotifyTest extends TestCase
{
    public function testCanCreateInstance()
    {
        $token = getenv('MOIP_ACCESS_TOKEN');
        $moip = new Moip(new OAuth($token), Moip::ENDPOINT_SANDBOX);
        $sn = new SimpleNotify('TEST_ENV', $moip);

        $this->assertInstanceOf(SimpleNotify::class, $sn);
    }

    public function testCanCreateRetrieveAndDeleteNotification()
    {
        $sn = $this->getInstance();
        // create
        $nEvent = $this->getNotificationEvent();
        $url = 'http://localhost';
        $n = $sn->createNotification($nEvent, $url);
    
        $this->assertInstanceOf(NotificationPreferences::class, $n);
        $events = $n->getEvents();
        $this->assertEquals($n->getTarget(), $url);
        $this->assertEquals(count($events), 1);
        $this->assertEquals($events[0], $nEvent);

        // retrieve
        $n = $sn->retrieveNotification($n->getId());
        $this->assertInstanceOf(NotificationPreferences::class, $n);

        // delete
        $nId = $n->getId();
        $n = $sn->deleteNotification($nId);
        $this->assertNull($n);
    }

    public function testCanListNotifications()
    {
        $sn = $this->getInstance();
        $nl = $sn->listNotifications();
        $this->assertInstanceOf(NotificationPreferencesList::class, $nl);
    }

    private function getInstance()
    {
        $token = getenv('MOIP_ACCESS_TOKEN');
        $moip = new Moip(new OAuth($token), Moip::ENDPOINT_SANDBOX);
        return new SimpleNotify('TEST_ENV', $moip);
    }

    private function getNotificationEvent()
    {
        $event = NotificationEvent::EVENT_PAYMENT_ANY;
        return new NotificationEvent($event);
    }
}
