<?php

namespace Entity;

class Country
{
    private $countryCode;
    private $countryName;

    public function __construct($countryCode, $countryName)
    {
        $this->countryCode = $countryCode;
        $this->countryName = $countryName;
    }

    public function getCountryName()
    {
        return $this->countryName;
    }

    public function getCountryCode()
    {
        return $this->countryCode;
    }
}
