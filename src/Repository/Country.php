<?php

namespace Repository;

use Entity\Countries;
use Silex\Application;

class Country
{
    private $mongodb;

    public function __construct(Application $app)
    {
        $this->mongodb = $app['mongodb']->{$app['db_name']}->countries;
    }

    #TODO Alterar para uma coleção de países ao invés de um array
    public function insertMany(array $countries)
    {
        $this->mongodb->insertMany($countries);
    }


    public function objectToArray(Countries $countries) : array
    {
        $countries_list = [];
        foreach ($countries as $country) {
            $item['country_code'] = $country->getCountryCode();
            $item['country_name'] = $country->getCountryName();
            $countries_list[] = $item;
        }
        return $countries_list;
    }
}