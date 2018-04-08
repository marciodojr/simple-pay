<?php

namespace Mdojr\SimplePay;

use Moip\Moip;
use Moip\Auth\OAuth;
use Mdojr\SimplePay\Customer\SimpleCustomer;
use Mdojr\SimplePay\Customer\SimpleOrder;
use Mdojr\SimplePay\Customer\SimplePayment;
use Moip\Resource\Customer;
use Moip\Resource\Orders;
use Moip\Resource\Holder as MoipHolder;
use Mdojr\SimplePay\Payment\Holder;
use Mdojr\SimplePay\Payment\SimpleCreditCardPayment;
use Mdojr\SimplePay\Payment\SimpleBoletoPayment;


class SimplePay
{
    private $namespace;
    private $moip;

    public function __construct(string $namespace, Moip $moip)
    {
        $this->namespace = $namespace;
        $this->moip = $moip;
    }

    /**
     * @todo: pesquisar por um simple customer ($this->namespace, $sc->ownId) antes de criar um novo
     */
    public function createCustomer(SimpleCustomer $sc)
    {
        $p = $sc->phone;
        $ba = $sc->baddress;
        $sa = $sc->saddress;

        $mCustomer = $this
            ->moip
            ->customers()
            ->setOwnId($this->uniqIdentifier('customer'))
            ->setFullname($sc->fullname)
            ->setEmail($sc->email)
            ->setBirthDate($sc->birthdate->format('Y-m-d'))
            ->setTaxDocument($sc->cpf)
            ->setPhone($p->areaCode, $p->number, $p->country)
            ->addAddress(
                Customer::ADDRESS_BILLING,
                $ba->street,
                $ba->number,
                $ba->district,
                $ba->city,
                $ba->state,
                $ba->zip,
                $ba->complement,
                $ba->country
            )
            ->addAddress(
                Customer::ADDRESS_SHIPPING,
                $sa->street,
                $sa->number,
                $sa->district,
                $sa->city,
                $sa->state,
                $sa->zip,
                $sa->complement,
                $sa->country
            );
        
        $mCustomer = $mCustomer->create();

        return $mCustomer->getId();
    }

    /**
     * @todo: pesquisar por uma simple order ($this->namespace, $so->ownId) antes de criar uma nova
     */
    public function createOrder(SimpleOrder $so)
    {
        $mCustomerId = $this->createCustomer($so->sc);

        $mOrder = $this
            ->moip
            ->orders()
            ->setOwnId($this->uniqIdentifier('order'))
            ->setShippingAmount($so->shippingAmount)
            ->setAddition($so->addition)
            ->setDiscount($so->discount)
            ->setCustomerId($mCustomerId);

        foreach ($so->items as $item) {
            $mOrder->addItem($item->name, $item->amount, $item->sku, $item->unitPriceInCents);
        }

        $mOrder = $mOrder->create();
        return $mOrder->getId();
    }

    private function uniqIdentifier($subnamespace = "")
    {
        return uniqid(sprintf("%s.%s", $this->namespace, $subnamespace), true);
    }

    public function createPaymentWithCreditCard(SimpleOrder $so, SimpleCreditCardPayment $scp)
    {
        $mOrderId = $this->createOrder($so);
        $mOrder = new Orders($this->moip);
        $mOrder = $mOrder->get($mOrderId);

        $payment = $mOrder
            ->payments()
            ->setCreditCardHash($scp->hash, $this->createMoipHolder($scp->holder))
            ->setInstallmentCount($scp->installmentCount)
            ->setStatementDescriptor($scp->statementDescriptor);
        
        $p = $payment->execute();
        return $p->getId();
    }

    public function createPaymentWithBoleto(SimpleOrder $so, SimpleBoletoPayment $sbp)
    {
        $mOrderId = $this->createOrder($so);
        $mOrder = new Orders($this->moip);
        $mOrder = $mOrder->get($mOrderId);

        $payment = $mOrder
            ->payments()
            ->setBoleto($sbp->expirationDate->format('Y-m-d'), $sbp->logoUri, $sbp->instructions);
        
        $p = $payment->execute();
        return $p->getId();
    }

    private function createMoipHolder(Holder $h)
    {

        $p = $h->phone;
        $addr = $h->address;

        $mHolder = new MoipHolder($this->moip);
        $mHolder
            ->setFullname($h->fullname)
            ->setBirthDate($h->birthdate->format('Y-m-d'))
            ->setTaxDocument($h->cpf)
            ->setPhone($p->areaCode, $p->number, $p->country)
            ->setAddress(
                MoipHolder::ADDRESS_BILLING,
                $addr->street,
                $addr->number,
                $addr->district,
                $addr->city,
                $addr->state,
                $addr->zip,
                $addr->complement,
                $addr->country
            );
        return $mHolder;
    }
}
