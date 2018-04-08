<?php

namespace Mdojr\SimplePay\Payment;

use Mdojr\SimplePay\Payment\SimpleBoletoPayment;
use Mdojr\SimplePay\Util\Phone;
use Mdojr\SimplePay\Util\Address;
use PHPUnit\Framework\TestCase;
use DateTime;

class SimpleBoletoPaymentTest extends TestCase
{

    public function testCanCreateInstance()
    {

        $logoUri = 'http://myurl/logo.png';
        $instructions = ['INSTRUÇÃO 1', 'INSTRUÇÃO 2', 'INSTRUÇÃO 3'];
        $expirationDate = new DateTime();

        $sbp = new SimpleBoletoPayment($logoUri, $instructions, $expirationDate);

        $this->assertInstanceOf(SimpleBoletoPayment::class, $sbp);
        $this->assertEquals($logoUri, $sbp->logoUri);
        $this->assertEquals($instructions, $sbp->instructions);
        $this->assertEquals($expirationDate, $sbp->expirationDate);
    }
}