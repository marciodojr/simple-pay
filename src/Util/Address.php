<?php

namespace Mdojr\SimplePay\Util;

use Mdojr\SimplePay\Util\StringStrip;

class Address
{
    private $street;
    private $number;
    private $district;
    private $city;
    private $state;
    private $zip;
    private $complement;
    private $country;

    const STATES = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO','MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI','RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];

    const COUNTRY_BRA = 'BRA';

    public function __construct(string $street, $number, string $district, string $city, string $state, $zip, string $complement = null, $country = self::COUNTRY_BRA)
    {

        if(!$this->validateState($state)) {
            throw new Exception('Estado inválido. O estado deve ser composto de duas letras');
        }

        $this->street = $street;
        $this->number = StringStrip::removeNonDigits($number);
        $this->district = $district;
        $this->city = $city;
        $this->state = $state;
        $this->zip = StringStrip::removeNonDigits($zip);
        $this->complement = $complement;
        $this->country = $country;
    }

    private function validateState($state)
    {
        return in_array($state, self::STATES);
    }

    public function __get($name)
    {
        return $this->$name;
    }
}
