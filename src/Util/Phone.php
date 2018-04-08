<?php

namespace Mdojr\SimplePay\Util;

use Mdojr\SimplePay\Util\StringStrip;

class Phone
{
    private $areaCode;
    private $number;
    private $country;

    public function __construct($areaCode, $number, $country = null)
    {
        $this->areaCode = StringStrip::removeNonDigits($areaCode);
        $this->number = StringStrip::removeNonDigits($number);
        $this->country = StringStrip::removeNonDigits($country);
    }

    public function __get($name)
    {
        return $this->$name;
    }
}
