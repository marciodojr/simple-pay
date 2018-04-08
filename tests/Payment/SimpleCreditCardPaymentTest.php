<?php

namespace Mdojr\SimplePay\Payment;

use Mdojr\SimplePay\Payment\SimpleCreditCardPayment;
use Mdojr\SimplePay\Util\Phone;
use Mdojr\SimplePay\Util\Address;
use PHPUnit\Framework\TestCase;
use DateTime;

class SimpleCreditCardPaymentTest extends TestCase
{
    public function testCanCreateInstance()
    {
        $hash = 'i1naupwpTLrCSXDnigLLTlOgtm+xBWo6iX54V/hSyfBeFv3rvqa1VyQ8/pqWB2JRQX2GhzfGppXFPCmd/zcmMyDSpdnf1GxHQHmVemxu4AZeNxs+TUAbFWsqEWBa6s95N+O4CsErzemYZHDhsjEgJDe17EX9MqgbN3RFzRmZpJqRvqKXw9abze8hZfEuUJjC6ysnKOYkzDBEyQibvGJjCv3T/0Lz9zFruSrWBw+NxWXNZjXSY0KF8MKmW2Gx1XX1znt7K9bYNfhA/QO+oD+v42hxIeyzneeRcOJ/EXLEmWUsHDokevOkBeyeN4nfnET/BatcDmv8dpGXrTPEoxmmGQ==';
        $holder = $this->getHolder();
        $installmentCount = 3;
        $statementDescriptor = 'Testando pagamento por cartão';

        $scp = new SimpleCreditCardPayment($hash, $holder, $installmentCount, $statementDescriptor);

        $this->assertInstanceOf(SimpleCreditCardPayment::class, $scp);

        $this->assertEquals($hash, $scp->hash);
        $this->assertEquals($holder, $scp->holder);
        $this->assertEquals($installmentCount, $scp->installmentCount);
        $this->assertEquals('Testando pag', $scp->statementDescriptor);
    }

    private function getHolder()
    {
        $fullname = 'Márcio Dias';
        $birthdate = new DateTime('1990-10-10');
        $cpf = '111.1111.111-11';
        $phone = new Phone(35, '1231-1231');
        $address = $this->getAddress();

        return new Holder($fullname, $birthdate, $cpf, $phone, $address);
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
