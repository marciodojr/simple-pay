<?php

namespace Mdojr\SimplePay\Payment;

use Mdojr\SimplePay\Payment\Holder;
use Mdojr\SimplePay\Util\Phone;
use Mdojr\SimplePay\Util\Address;
use Mdojr\SimplePay\Util\StringStrip;
use PHPUnit\Framework\TestCase;
use DateTime;

class HolderTest extends TestCase
{

    private $fullname;
    private $birthdate;
    private $cpf;
    private $phone;
    private $address;

    public function testCanCreateInstance()
    {
        $fullname = 'Márcio Dias';
        $birthdate = new DateTime('1990-10-10');
        $cpf = '111.111.111-11';
        $phone = new Phone(35, '1231-1231');
        $address = $this->getAddress();

        $h = new Holder($fullname, $birthdate, $cpf, $phone, $address);

        $this->assertInstanceOf(Holder::class, $h);
        $this->assertEquals($fullname, $h->fullname);
        $this->assertEquals($birthdate, $h->birthdate);
        $this->assertEquals(StringStrip::removeNonDigits($cpf), $h->cpf);
        $this->assertEquals($phone, $h->phone);
        $this->assertEquals($address, $h->address);
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