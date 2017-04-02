<?php

namespace Model;

use Entity\Countries;
use Entity\Country as CountryEntity;
use GuzzleHttp\Client;

class Country
{
    private $guzzleClient;
    private $countryRepository;

    const ORDER_ASC = 1;
    const ORDER_DESC = -1;

    public function __construct(Client $client, \Repository\Country $repository)
    {
        $this->guzzleClient = $client;
        $this->countryRepository = $repository;
    }

    public function getCountriesList() : Countries
    {
        $response = $this->guzzleClient->request('GET');
        $textResponse = $response->getBody()->getContents();
        return $this->parseResponse($textResponse);
    }

    public function countriesListOrderByName($order) :Countries
    {
        $countries = $this->countryRepository->countriesOrderByCountryName($order);
        $countriesArray = iterator_to_array($countries);

        $countriesCollection = new Countries();
        foreach ($countriesArray as $country) {
            $countriesCollection->add(
                new CountryEntity($country->country_code, $country->country_name)
            );
        }
        return $countriesCollection;
    }

    private function parseResponse(string $text) : Countries
    {
        $response_as_array = explode("\n", $text);
        unset($response_as_array[0]);
        unset($response_as_array[1]);
        unset($response_as_array[2]);
        unset($response_as_array[255]);

        $countriesCollection = new Countries();
        foreach ($response_as_array as $line) {
            preg_match('/(\w*)\s{3}(.*)/', $line, $matches);

            $countriesCollection->add(
                new CountryEntity($matches[1], $matches[2])
            );
        }

        return $countriesCollection;
    }
}