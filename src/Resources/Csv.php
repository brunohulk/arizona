<?php

namespace Resources;

use Entity\Countries;

class Csv
{
    private $csvFile;
    private $output;

    public function __construct($tmpFile)
    {
        $this->csvFile = $tmpFile;
        $this->output = fopen($this->csvFile, "w");
    }

    public function export(Countries $countries)
    {
        fputcsv($this->output, array('Country Name','Country Code'), ',');
        foreach ($countries as $country) {
            $row = [$country->getCountryName(), $country->getCountryCode()];
            fputcsv($this->output, $row, ',');
        }
        ob_end_clean();
        fpassthru($this->output);
        return $this->csvFile;
    }

    public function __destruct()
    {
        fclose($this->output);
    }
}
