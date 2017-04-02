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

        $this->assertInternalType('array', $countriesList);
        $this->assertCount(252, $countriesList, "It must return 252 countries");
        $this->assertEquals(current($countriesList), 'Andorra');
        $this->assertEquals($countriesList['IO'], 'British Indian Ocean Territory');
        $this->assertEquals($countriesList['CI'], "Cote D'Ivoire (Ivory Coast)");
        $this->assertEquals(end($countriesList), 'Nato field');
    }
}