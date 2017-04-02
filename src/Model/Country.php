<?php

namespace Model;

use GuzzleHttp\Client;

class Country
{
    private $guzzleClient;

    public function __construct(Client $client)
    {
        $this->guzzleClient = $client;
    }

    public function getCountriesList() : array
    {
        $response = $this->guzzleClient->request('GET');
        $textResponse = $response->getBody()->getContents();
        return $this->parseResponse($textResponse);
    }

    private function parseResponse(string $text) : array
    {
        $response_as_array = explode("\n", $text);
        unset($response_as_array[0]);
        unset($response_as_array[1]);
        unset($response_as_array[2]);
        unset($response_as_array[255]);

        $countries = [];
        foreach ($response_as_array as $line) {
            preg_match('/(\w*)\s{3}(.*)/', $line, $matches);
            $countries[] = ["CountryCode" => $matches[1], "CountryName" => $matches[2]];
        }

        return $countries;
    }
}