<?php

namespace Mdojr\SimplePay\Util;

use PHPUnit\Framework\TestCase;
use Mdojr\SimplePay\Util\BankAccount;

class BankAccountTest extends TestCase
{

    public function testCanCreateBankAccountInstance()
    {
        $bankNumber = '001';
        $agencyNumber ='0308';
        $agencyCheckNumber = '5';
        $accountNumber = '10000';
        $accountCheckNumber = '10';

        $ba = new BankAccount($bankNumber, $agencyNumber, $agencyCheckNumber, $accountNumber, $accountCheckNumber);
        $this->assertInstanceOf(BankAccount::class, $ba);
        $this->assertEquals($ba->bankNumber, $bankNumber);
        $this->assertEquals($ba->agencyNumber, $agencyNumber);
        $this->assertEquals($ba->agencyCheckNumber, $agencyCheckNumber);
        $this->assertEquals($ba->accountNumber, $accountNumber);
        $this->assertEquals($ba->accountCheckNumber, $accountCheckNumber);
    }

}