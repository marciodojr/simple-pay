<?php

namespace Mdojr\SimplePay\Payment;

use Mdojr\SimplePay\Payment\Holder;

class SimpleCreditCardPayment
{

    private $hash;
    private $holder;
    private $installmentCount;
    private $statementDescriptor;

    public function __construct(string $hash, Holder $holder, int $installmentCount, string $statementDescriptor)
    {
        $this->hash = $hash;
        $this->holder = $holder;
        $this->installmentCount = $installmentCount;
        $this->statementDescriptor = substr($statementDescriptor, 0, 12);
    }

    public function __get($name)
    {
        return $this->$name;
    }
}