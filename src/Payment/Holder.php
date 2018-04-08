<?php

namespace Mdojr\SimplePay\Payment;

use DateTime;

use Mdojr\SimplePay\Util\Phone;
use Mdojr\SimplePay\Util\Address;
use Mdojr\SimplePay\Util\StringStrip;

class Holder
{

    private $fullname;
    private $birthdate;
    private $cpf;
    private $phone;
    private $address;

    public function __construct(string $fullname, DateTime $birthdate, $cpf, Phone $phone, Address $address)
    {
        $this->fullname = $fullname;
        $this->birthdate = $birthdate;
        $this->cpf = StringStrip::removeNonDigits($cpf);
        $this->phone = $phone;
        $this->address = $address;
    }

    public function __get($name)
    {
        return $this->$name;
    }
}