<?php

namespace Mdojr\SimplePay\Util;

use Mdojr\SimplePay\Util\Phone;
use Mdojr\SimplePay\Util\StringStrip;
use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    public function testCanCreateInstance()
    {
        $areaCode = 'sab35';
        $number = '23234-34234';
        $country = '55a';

        $phone = new Phone($areaCode, $number, $country);
        $phone2 = new Phone($areaCode, $number);

        $this->assertInstanceOf(Phone::class, $phone);
        $this->assertInstanceOf(Phone::class, $phone2);

        $this->assertEquals(StringStrip::removeNonDigits($areaCode), $phone->areaCode);
        $this->assertEquals(StringStrip::removeNonDigits($number), $phone->number);
        $this->assertEquals(StringStrip::removeNonDigits($country), $phone->country);
    }
}