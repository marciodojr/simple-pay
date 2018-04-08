<?php

namespace Mdojr\SimplePay\Customer;


use DateTime;
use Mdojr\SimplePay\Customer\SimpleCustomer;
use PHPUnit\Framework\TestCase;
use Mdojr\SimplePay\Util\Phone;
use Mdojr\SimplePay\Util\Address;
use Mdojr\SimplePay\Util\StringStrip;

class SimpleCustomerTest extends TestCase
{

    public function testCanCreateInstance()
    {
        $fullname = 'Márcio Dias';
        $email = 'marciojr91@gmail.com';
        $birthdate = new DateTime('1991-12-06');
        $cpf = '111.111.111-11';
        $phone = new Phone(35, '1231-1231');
        $address = $this->getAddress();

        $sc = new SimpleCustomer(uniqid(), $fullname, $email, $birthdate, $cpf, $phone, $address, $address);

        $this->assertInstanceOf(SimpleCustomer::class, $sc);
        
        $this->assertEquals($fullname, $sc->fullname);
        $this->assertEquals($email, $sc->email);
        $this->assertEquals($birthdate, $sc->birthdate);
        $this->assertEquals(StringStrip::removeNonDigits($cpf), $sc->cpf);
        $this->assertEquals($phone, $sc->phone);
        $this->assertEquals($address, $sc->saddress);
        $this->assertEquals($address, $sc->baddress);
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