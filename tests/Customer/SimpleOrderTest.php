<?php

namespace Mdojr\SimplePay\Customer;

use Mdojr\SimplePay\Util\Phone;
use Mdojr\SimplePay\Util\Address;
use Mdojr\SimplePay\Customer\SimpleCustomer;
use Mdojr\SimplePay\Customer\SimpleOrder;
use Mdojr\SimplePay\Customer\OrderItem;
use PHPUnit\Framework\TestCase;
use DateTime;

class SimpleOrderTest extends TestCase
{
    public function testCanCreateInstance()
    {
        $items = [
            new OrderItem("bicicleta 1", 1, "sku1", 10000),
            new OrderItem("bicicleta 2", 1, "sku2", 11000),
            new OrderItem("bicicleta 3", 1, "sku3", 12000),
            new OrderItem("bicicleta 4", 1, "sku4", 13000),
            new OrderItem("bicicleta 5", 1, "sku5", 14000),
        ];

        $shippingAmount = 20000;
        $addition = 3000;
        $discount = 1000;

        $sc = $this->getSimpleCustomerInstance();
        $so = new SimpleOrder(uniqid(), $sc, $items, $shippingAmount, $addition, $discount);

        $this->assertInstanceOf(SimpleOrder::class, $so);

        $this->assertEquals($sc, $so->sc);
        $this->assertEquals($items, $so->items);
        $this->assertEquals($shippingAmount, $so->shippingAmount);
        $this->assertEquals($addition, $so->addition);
        $this->assertEquals($discount, $so->discount);
    }

    private function getSimpleCustomerInstance()
    {
        $fullname = 'Márcio Dias';
        $email = 'marciojr91@gmail.com';
        $birthdate = new DateTime('1991-12-06');
        $cpf = '111.111.111-11';
        $phone = new Phone(35, '1231-1231');
        $address = $this->getAddress();
        return new SimpleCustomer(uniqid(), $fullname, $email, $birthdate, $cpf, $phone, $address);
    }

    public function getAddress()
    {
        $street = 'Rua ABC';
        $number = '34334-a';
        $district = 'Bairro X';
        $city = 'Cidade 1';
        $state = 'MG';
        $zip = '37500-145';
        $complement = 'Casa amarela';

        return new Address($street, $number, $district, $city, $state, $zip, $complement);
    }
}
