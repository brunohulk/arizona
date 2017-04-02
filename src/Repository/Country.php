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

    public function insertMany(array $countries)
    {
        $this->mongodb->insertMany($countries);
    }

    public function countriesOrderByCountryName($order = \Model\Country::ORDER_ASC)
    {
        return $this->mongodb->find([], ['sort' => ['country_name' => $order]]);
    }

    #TODO Método estático =( por causa do teste, estudar uma melhor forma
    public static function objectToArray(Countries $countries) : array
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
