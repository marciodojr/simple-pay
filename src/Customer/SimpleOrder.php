<?php

namespace Mdojr\SimplePay\Customer;

use Mdojr\SimplePay\Customer\SimpleCustomer;

class SimpleOrder
{
    private $ownId;
    private $sc;
    private $items;
    private $shippingAmount;
    private $addition;
    private $discount;

    public function __construct($ownId, SimpleCustomer $sc, array $items, int $shippingAmount = 0, int $addition = 0, int $discount = 0)
    {
        $this->ownId = $ownId;
        $this->sc = $sc;
        $this->items = $items;
        $this->shippingAmount = $shippingAmount;
        $this->addition = $addition;
        $this->discount = $discount;
    }

    public function __get($name)
    {
        return $this->$name;
    }
}
