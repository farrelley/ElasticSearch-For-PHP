<?php
require_once '../scripts/params.php';

$elastica = new Elastica_Client();
$index = $elastica->getIndex($config->location->airportCode);
$breweryType = $index->getType('brewery');

$matchAll = new Elastica_Query_MatchAll();
$query = new Elastica_Query($matchAll);

$results = $breweryType->search($query);


echo "<pre>";
print_r($results);