<?php

namespace Mdojr\SimplePay;

use Moip\Moip;
use Mdojr\SimplePay\Notify\NotificationEvent;


class SimpleNotify
{
    private $namespace;
    private $moip;

    public function __construct(string $namespace, Moip $moip)
    {
        $this->namespace = $namespace;
        $this->moip = $moip;
    }

    /**
     * @return Moip\Resource\NotificationPreferencesList
     */
    public function listNotifications()
    {
        return $this
            ->moip
            ->notifications()
            ->getList();
    }

    /**
     * @return Moip\Resource\NotificationPreferences
     */
    public function deleteNotification($notificationId)
    {
        return $this
            ->moip
            ->notifications()
            ->delete($notificationId);
    }

    /**
     * @return Moip\Resource\NotificationPreferences
     */
    public function createNotification(NotificationEvent $event, $url)
    {
        return $this
            ->moip
            ->notifications()
            ->addEvent((string)$event)
            ->setTarget($url)
            ->create();
    }

    /**
     * @return Moip\Resource\NotificationPreferences
     */
    public function retrieveNotification($notificationId)
    {
        return $this
            ->moip
            ->notifications()
            ->get($notificationId);
    }
}