<?php

namespace Entity;

class Countries extends \ArrayObject
{
    public function add(Country $country)
    {
        $this->append($country);
    }
}