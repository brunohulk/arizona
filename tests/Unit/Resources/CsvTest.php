<?php

namespace Unit\Resources;

use Entity\Countries;
use Entity\Country;
use PHPUnit\Framework\TestCase;
use Resources\Csv;

class CsvTest extends TestCase
{
    private $csv;

    const TEMP_FILE_PATH = '/tmp/temp.csv';

    public function setUp()
    {
        $this->csv = new Csv(self::TEMP_FILE_PATH);
    }

    public function testIfTheCsvHasBeenGenerated()
    {
        $this->csv->export($this->fixtureCountries());

        $lines = file(self::TEMP_FILE_PATH);

        $this->assertEquals('"Country Name","Country Code"', trim($lines[0]));
        $this->assertEquals('Brazil,BR', trim($lines[1]));
        $this->assertEquals('Argentina,AR', trim($lines[2]));
    }

    public function tearDown()
    {
        unlink(self::TEMP_FILE_PATH);
    }

    private function fixtureCountries()
    {
        $countries = new Countries();
        $countries->add(new Country('BR', 'Brazil'));
        $countries->add(new Country('AR', 'Argentina'));

        return $countries;
    }
}
