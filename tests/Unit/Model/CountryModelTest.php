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
    private $repositoryMock;

    public function setUp()
    {
        parent::setUp();

        $pageContent = file_get_contents(dirname(__FILE__) . '/../Fixtures/country_response.txt');
        $response = new Response(200, ['Content-Type' => 'text/plain'], $pageContent);

        $this->guzzleMock = Mockery::mock('GuzzleHttp\Client');
        $this->guzzleMock->shouldReceive('request')->once()->andReturn($response);

        $this->repositoryMock = Mockery::mock('Repository\Country');
        $this->repositoryMock->shouldReceive('countriesOrderByCountryName')->with(Country::ORDER_ASC)
            ->andReturn($this->fixtureOrderCountries(Country::ORDER_ASC));

        $this->repositoryMock->shouldReceive('countriesOrderByCountryName')->with(Country::ORDER_DESC)
            ->andReturn($this->fixtureOrderCountries(Country::ORDER_DESC));

        $this->countryModel = new Country($this->guzzleMock, $this->repositoryMock);
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

    public function testCountriesListOrderByNameAsc()
    {
        $result = $this->countryModel->countriesListOrderByName(Country::ORDER_ASC);

        $this->assertEquals('Entity\Countries', get_class($result));
        $this->assertCount(2, $result);
        $this->assertEquals('Argentina', $result[0]->getCountryName());
        $this->assertEquals('Brazil', $result[1]->getCountryName());
    }

    public function testCountriesListOrderByNameDesc()
    {
        $result = $this->countryModel->countriesListOrderByName(Country::ORDER_DESC);

        $this->assertEquals('Entity\Countries', get_class($result));
        $this->assertCount(2, $result);
        $this->assertEquals('Brazil', $result[0]->getCountryName());
        $this->assertEquals('Argentina', $result[1]->getCountryName());
    }

    private function fixtureOrderCountries($order = Country::ORDER_ASC)
    {
        $country = new \stdClass();
        $country->country_code = 'Ar';
        $country->country_name = 'Argentina';

        $country2 = new \stdClass();
        $country2->country_code = 'BR';
        $country2->country_name = 'Brazil';

        if ($order == Country::ORDER_ASC) {
            return [$country, $country2];
        }

        return [$country2, $country];
    }
}
