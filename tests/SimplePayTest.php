<?php

namespace Mdojr\SimplePay;

use Mdojr\SimplePay\SimplePay;
use Mdojr\SimplePay\Customer\SimpleCustomer;
use PHPUnit\Framework\TestCase;
use Moip\Moip;
use Moip\Auth\OAuth;
use DateTime;
use Mdojr\SimplePay\Util\Phone;
use Mdojr\SimplePay\Util\Address;
use Exception;
use Moip\Exceptions\ValidationException;
use Mdojr\SimplePay\Customer\OrderItem;
use Mdojr\SimplePay\Customer\SimpleOrder;
use Mdojr\SimplePay\Payment\Holder;
use Mdojr\SimplePay\Payment\SimpleCreditCardPayment;
use Mdojr\SimplePay\Payment\SimpleBoletoPayment;

class SimplePayTest extends TestCase
{
    public function testCanCreateInstance()
    {
        $sp = $this->getInstance();
        $this->assertInstanceOf(SimplePay::class, $sp);
    }

    public function testCanCreateMoipCustomer()
    {
        $sp = $this->getInstance();
        $sc = $this->getSimpleCustomerInstance();
        $c = $sp->createCustomer($sc);

        $this->assertTrue(strpos($c, 'CUS-') !== false);
    }

    public function testCanCreateMoipOrder()
    {
        $so = $this->getSimpleOrderInstance();
        $sp = $this->getInstance();
        $mo = $sp->createOrder($so);
        $this->assertTrue(strpos($mo, 'ORD-') !== false);
    }

    public function testCanCreateMoipPaymentWithCreditCard()
    {
        $sp = $this->getInstance();
        $so = $this->getSimpleOrderInstance();
        $scp = $this->getSimpleCreditCardPayment();
        
        $pc = $sp->createPaymentWithCreditCard($so, $scp);
        $this->assertTrue(strpos($pc, 'PAY-') !== false);
    }

    public function testCanCreateMoipPaymentWithBoleto()
    {
        $sp = $this->getInstance();
        $so = $this->getSimpleOrderInstance();
        $sbp = $this->getSimpleBoletoPayment();
        
        $pb = $sp->createPaymentWithBoleto($so, $sbp);
        $this->assertTrue(strpos($pb, 'PAY-') !== false);
    }

    private function getSimpleBoletoPayment()
    {
        $logoUri = 'http://myurl/logo.png';
        $instructions = ['INSTRUÇÃO 1', 'INSTRUÇÃO 2', 'INSTRUÇÃO 3'];
        $expirationDate = new DateTime();

        return new SimpleBoletoPayment($logoUri, $instructions, $expirationDate);
    }

    private function getSimpleCreditCardPayment()
    {
        $hash = 'i1naupwpTLrCSXDnigLLTlOgtm+xBWo6iX54V/hSyfBeFv3rvqa1VyQ8/pqWB2JRQX2GhzfGppXFPCmd/zcmMyDSpdnf1GxHQHmVemxu4AZeNxs+TUAbFWsqEWBa6s95N+O4CsErzemYZHDhsjEgJDe17EX9MqgbN3RFzRmZpJqRvqKXw9abze8hZfEuUJjC6ysnKOYkzDBEyQibvGJjCv3T/0Lz9zFruSrWBw+NxWXNZjXSY0KF8MKmW2Gx1XX1znt7K9bYNfhA/QO+oD+v42hxIeyzneeRcOJ/EXLEmWUsHDokevOkBeyeN4nfnET/BatcDmv8dpGXrTPEoxmmGQ==';
        $holder = $this->getHolder();
        $installmentCount = 3;
        $statementDescriptor = 'Testando pagamento por cartão';

        return new SimpleCreditCardPayment($hash, $holder, $installmentCount, $statementDescriptor);
    }

    private function getHolder()
    {
        $fullname = 'Márcio Dias';
        $birthdate = new DateTime('1990-10-10');
        $cpf = '111.111.111-11';
        $phone = new Phone(35, '1231-1231');
        $address = $this->getAddress();

        return new Holder($fullname, $birthdate, $cpf, $phone, $address);
    }

    private function getInstance()
    {
        $token = getenv('MOIP_ACCESS_TOKEN');
        $moip = new Moip(new OAuth($token), Moip::ENDPOINT_SANDBOX);
        return new SimplePay('TEST_ENV', $moip);
    }

    private function getSimpleOrderInstance()
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
        return new SimpleOrder(uniqid(), $sc, $items, $shippingAmount, $addition, $discount);
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
