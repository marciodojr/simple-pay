<?php

namespace Mdojr\SimplePay\Payment;

use DateTime;

class SimpleBoletoPayment
{

    private $logoUri;
    private $instructions;
    private $expirationDate;

    public function __construct(string $logoUri, array $instructions, DateTime $expirationDate)
    {
        $this->logoUri = $logoUri;
        $this->instructions = $instructions;
        $this->expirationDate = $expirationDate;
    }

    public function __get($name)
    {
        return $this->$name;
    }
}