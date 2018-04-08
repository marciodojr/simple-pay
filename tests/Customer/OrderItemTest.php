<?php

namespace Mdojr\SimplePay\Customer;

use Mdojr\SimplePay\Customer\OrderItem;
use PHPUnit\Framework\TestCase;

class OrderItemTest extends TestCase
{

    public function testCanCreateInstance()
    {

        $name = 'Bicicleta Caloi';
        $amount = 2;
        $sku = 'B001';
        $unitPriceInCents = 15000;
        $oi = new OrderItem($name, $amount, $sku, $unitPriceInCents);

        $this->assertInstanceOf(OrderItem::class, $oi);
        $this->assertEquals($name, $oi->name);
        $this->assertEquals($amount, $oi->amount);
        $this->assertEquals($sku, $oi->sku);
        $this->assertEquals($unitPriceInCents, $oi->unitPriceInCents);
    }

}