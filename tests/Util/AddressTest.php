<?php

namespace Mdojr\SimplePay\Util;

use Mdojr\SimplePay\Util\Address;
use Mdojr\SimplePay\Util\StringStrip;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    public function testCanCreateInstance()
    {

        $street = 'Rua ABC';
        $number = '34334-a';
        $district = 'Bairro X';
        $city = 'Cidade 1';
        $state = 'MG';
        $zip = '37500-145';
        $complement = 'Casa amarela';

        $addr = new Address($street, $number, $district, $city, $state, $zip, $complement);
        $addr2 = new Address($street, $number, $district, $city, $state, $zip);

        $this->assertInstanceOf(Address::class, $addr);
        $this->assertInstanceOf(Address::class, $addr2);

        $this->assertEquals($street, $addr->street);
        $this->assertEquals(StringStrip::removeNonDigits($number), $addr->number);
        $this->assertEquals($district, $addr->district);
        $this->assertEquals($city, $addr->city);
        $this->assertEquals($state, $addr->state);
        $this->assertEquals(StringStrip::removeNonDigits($zip), $addr->zip);
        $this->assertEquals($complement, $addr->complement);

    }
}