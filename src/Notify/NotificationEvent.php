<?php

namespace Mdojr\SimplePay\Notify;

use InvalidArgumentException;

class NotificationEvent
{

    const EVENT_PAYMENT_ANY = 'PAYMENT.*';
    const EVENT_REFUND_ANY = 'REFUND.*';

    private $event;

    public function __construct(string $event)
    {
        if(!$this->isValid($event)) {
            throw new InvalidArgumentException("Evento '$event' é inválido");
        }

        $this->event = $event;
    }

    private function isValid($event)
    {
        return in_array($event, [self::EVENT_PAYMENT_ANY, self::EVENT_REFUND_ANY]);
    }

    public function __toString()
    {
        return $this->event;
    }
}
