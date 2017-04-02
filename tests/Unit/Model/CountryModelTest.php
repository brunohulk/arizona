<?php

namespace Unit\Model;

use Model\Country;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Response;
use Mockery;

class CountryModelTest extends TestCase
{
    private $countryModel;
    private $guzzleMock;

    public function setUp()
    {
        parent::setUp();

        $pageContent = file_get_contents(dirname(__FILE__) . '/../Fixtures/country_response.txt');
        $response = new Response(200, ['Content-Type' => 'text/plain'], $pageContent);

        $this->guzzleMock = Mockery::mock('GuzzleHttp\Client');
        $this->guzzleMock->shouldReceive('request')->once()->andReturn($response);

        $this->countryModel = new Country($this->guzzleMock);
    }

    public function testCountryResponseShouldBeAnArrayOfCountries()
    {
        $countriesList = $this->countryModel->getCountriesList();

        $this->assertEquals('Entity\Countries', get_class($countriesList));
        $this->assertCount(252, $countriesList, "It must return 252 countries");

        $this->assertEquals(current($countriesList)->getCountryName(), 'Andorra');
        $this->assertEquals($countriesList['192']->getCountryName(), "Svalbard and Jan Mayen Islands");
        $this->assertEquals($countriesList['192']->getCountryCode(), "SJ");
        $this->assertEquals(end($countriesList)->getCountryName(), 'Nato field');
    }
}