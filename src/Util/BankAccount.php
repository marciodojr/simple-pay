<?php

namespace Mdojr\SimplePay\Util;

// use Mdojr\SimplePay\Util\StringStrip;

class BankAccount
{

    private $bankNumber;
    private $agencyNumber;
    private $agencyCheckNumber;
    private $accountNumber;
    private $accountCheckNumber;

    public function __construct($bankNumber, $agencyNumber, $agencyCheckNumber, $accountNumber, $accountCheckNumber)
    {
        $this->bankNumber = $bankNumber;
        $this->agencyNumber = $agencyNumber;
        $this->agencyCheckNumber = $agencyCheckNumber;
        $this->accountNumber = $accountNumber;
        $this->accountCheckNumber = $accountCheckNumber;
    }


    public function __get($name)
    {
        return $this->$name;
    }

}