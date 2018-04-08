<?php

namespace Mdojr\SimplePay\Customer;

class OrderItem
{
    private $name;
    private $amount;
    private $sku;
    private $unitPriceInCents;

    public function __construct($name, $amount, $sku, $unitPriceInCents)
    {
        $this->name = $name;
        $this->amount = $amount;
        $this->sku = $sku;
        $this->unitPriceInCents = $unitPriceInCents;
    }

    public function __get($name)
    {
        return $this->$name;
    }
}
