<?php

namespace Mdojr\SimplePay\Util;


class StringStrip
{
    public static function removeNonDigits($value)
    {
        return preg_replace('/\D/', '', $value);
    }
}