<?php

namespace Mdojr\SimplePay\Util;

use Mdojr\SimplePay\Util\StringStrip;
use PHPUnit\Framework\TestCase;

class StringStripTest extends TestCase
{
    public function testCanRemoveNonDigits()
    {
        $string = '232  34\\4';
        $this->assertEquals(232344, StringStrip::removeNonDigits($string));
    }
}