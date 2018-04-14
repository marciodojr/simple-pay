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
use Moip\Resource\Payment;
use Moip\Resource\Orders;
use Moip\Resource\Refund;
use Moip\Resource\Customer;
use Mdojr\SimplePay\Util\BankAccount;

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

        $this->assertTrue(strpos($c->getId(), 'CUS-') !== false);
    }

    public function testCanCreateMoipOrder()
    {
        $so = $this->getSimpleOrderInstance();
        $sp = $this->getInstance();
        $mo = $sp->createOrder($so);
        $this->assertTrue(strpos($mo->getId(), 'ORD-') !== false);
    }

    public function testCanCreateMoipPaymentWithCreditCard()
    {
        $sp = $this->getInstance();
        $so = $this->getSimpleOrderInstance();
        $scp = $this->getSimpleCreditCardPayment();
        
        $pc = $sp->createPaymentWithCreditCard($so, $scp);
        $this->assertTrue(strpos($pc->getId(), 'PAY-') !== false);
    }

    public function testCanRetrieveCustomer()
    {
        $sp = $this->getInstance();
        $sc = $this->getSimpleCustomerInstance();
        $c = $sp->createCustomer($sc);

        $cId = $c->getId();
        $cr = $sp->retrieveCustomer($cId);
        $this->assertInstanceOf(Customer::class, $cr);
        $this->assertEquals($cr->getId(), $cId);
    }

    public function testCanRetrieveOrder()
    {
        $so = $this->getSimpleOrderInstance();
        $sp = $this->getInstance();
        $mo = $sp->createOrder($so);
        
        $oid = $mo->getId();
        $mor = $sp->retrieveOrder($oid);

        $this->assertInstanceOf(Orders::class, $mor);
        $this->assertEquals($mor->getId(), $oid);
    }

    public function testCanRetrivePayment()
    {
        $sp = $this->getInstance();
        $so = $this->getSimpleOrderInstance();
        $scp = $this->getSimpleCreditCardPayment();
        
        $pc = $sp->createPaymentWithCreditCard($so, $scp);
        $pId = $pc->getId();
        $pr = $sp->retrievePayment($pId);

        $this->assertInstanceOf(Payment::class, $pr);
        $this->assertEquals($pr->getId(), $pId);
    }

    public function testCanCreateMoipPaymentWithBoleto()
    {
        $sp = $this->getInstance();
        $so = $this->getSimpleOrderInstance();
        $sbp = $this->getSimpleBoletoPayment();
        
        $pb = $sp->createPaymentWithBoleto($so, $sbp);
        $this->assertTrue(strpos($pb->getId(), 'PAY-') !== false);
    }

    public function testCanRefundWithCreditCard()
    {
        $sp = $this->getInstance();
        $so = $this->getSimpleOrderInstance();
        $scp = $this->getSimpleCreditCardPayment();
        $pc = $sp->createPaymentWithCreditCard($so, $scp);

        $ref = $sp->refundPaymentWithCreditCard($pc->getId());
        $this->assertInstanceOf(Refund::class, $ref);
    }

    public function testCanRefundWithBankAccount()
    {
        $sp = $this->getInstance();
        $so = $this->getSimpleOrderInstance();
        $sbp = $this->getSimpleBoletoPayment();
        $pb = $sp->createPaymentWithBoleto($so, $sbp);

        $pId = $pb->getId();
        $ba = $this->getBankAccount();
        $cId = $pb->getOrder()->getCustomer()->getId();
        
        $this->expectException(ValidationException::class);
        $ref = $sp->refundPaymentWithBankAccount($pId, $ba, $cId);        
    }

    public function testCanRefundWithBankAccountFromCreditCard()
    {
        $sp = $this->getInstance();
        $so = $this->getSimpleOrderInstance();
        $scp = $this->getSimpleCreditCardPayment();
        $pc = $sp->createPaymentWithCreditCard($so, $scp);

        $pId = $pc->getId();
        $ba = $this->getBankAccount();
        $cId = $pc->getOrder()->getCustomer()->getId();

        $this->expectException(ValidationException::class);
        $ref = $sp->refundPaymentWithBankAccount($pId, $ba, $cId);
    }

    private function getBankAccount()
    {
        $bankNumber = '001';
        $agencyNumber ='0308';
        $agencyCheckNumber = '5';
        $accountNumber = '10000';
        $accountCheckNumber = '10';

        return new BankAccount($bankNumber, $agencyNumber, $agencyCheckNumber, $accountNumber, $accountCheckNumber);
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
        $hash = 'azkBMZ3SC/MiKZABh4Twyz2G8yT97yqHV3CxaVmQHOzZ+o4xEHP5crhrXuCPBiwKo1MnWqhcbczgLGZ1ov5nZ03kDGylwcO3St70NcBM5NqukPwBqBEMGJ1AZj+KD8H1UPJlEomh9RN/iLdrKCC3t+HS8ypSDyRmxPK5qCHR7ilQx1oYZYAJPcGVi2WuHvfMRshzmprILHxWGbKKlON2CUm4lK5id6YX+WPfEC9ZXMSIXWo8Ox3MPXtCLK6LRz+315ZIxL8gP2JRLSSsutxcuhj75LBImoXmYcX7vtt280BSgDjxEh1ZcBsfESQsW8tnIdIJazAtBEIOYIW+x6NkMw==';
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
