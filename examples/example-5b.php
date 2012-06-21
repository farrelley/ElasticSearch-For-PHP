<?php
require_once '../scripts/params.php';

$elastica = new Elastica_Client();
$index = $elastica->getIndex($config->location->airportCode);
$type = $index->getType('beer');

$queryField = new Elastica_Query_Field();
$queryField->setField('style');
$queryField->setQueryString('Stout');

$query = new Elastica_Query($queryField);

$results = $type->search($query);

echo "<pre>";
print_r($results);