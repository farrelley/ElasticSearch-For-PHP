<?php
require_once '../scripts/params.php';

$elastica = new Elastica_Client();
$index = $elastica->getIndex($config->location->airportCode);
$breweryType = $index->getType('brewery');

$results = $breweryType->search('lonerider');

echo "<pre>";
print_r($results);