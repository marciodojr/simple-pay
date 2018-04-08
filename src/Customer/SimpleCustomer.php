<?php

namespace Mdojr\SimplePay\Customer;


use DateTime;
use Mdojr\SimplePay\Util\Phone;
use Mdojr\SimplePay\Util\Address;
use Mdojr\SimplePay\Util\StringStrip;

class  SimpleCustomer
{

    private $ownId;
    private $fullname;
    private $email;
    private $birthdate;
    private $cpf;
    private $phone;
    private $saddress;
    private $baddress;

    public function __construct($ownId, string $fullname, string $email, DateTime $birthdate, $cpf, Phone $phone, Address $saddress, Address $baddress = null)
    {
        $this->ownId = $ownId;
        $this->fullname = $fullname;
        $this->email = $email;
        $this->birthdate = $birthdate;
        $this->cpf = StringStrip::removeNonDigits($cpf);
        $this->phone = $phone;
        $this->saddress = $saddress;
        $this->baddress = $baddress ?? $saddress;
    }

    public function __get($name)
    {
        return $this->$name;
    }
}