<?php

namespace Model;

use Entity\Countries;
use Entity\Country as CountryEntity;
use GuzzleHttp\Client;
use Symfony\Component\Validator\Tests\Fixtures\Entity;

class Country
{
    private $guzzleClient;

    public function __construct(Client $client)
    {
        $this->guzzleClient = $client;
    }

    public function getCountriesList() : Countries
    {
        $response = $this->guzzleClient->request('GET');
        $textResponse = $response->getBody()->getContents();
        return $this->parseResponse($textResponse);
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