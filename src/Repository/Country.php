<?php

namespace Repository;

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
}