<?php

namespace Unit\Repository;

use Entity\Countries;
use PHPUnit\Framework\TestCase;
use Mockery;

class Country extends TestCase
{
    public function testIfTheCountryObjectBecomesAnValidArray()
    {
        $countries = new Countries();

        $countries->add(new \Entity\Country("BR", "Brazil"));
        $countries->add(new \Entity\Country("AR", "Argentina"));

        $result = \Repository\Country::objectToArray($countries);

        $this->assertEquals(
            [
                ['country_code' => 'BR', 'country_name' => 'Brazil'],
                ['country_code' => 'AR', 'country_name' => 'Argentina']
            ],
            $result
        );

    }
}