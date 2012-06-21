<?php
require_once '../scripts/params.php';

$elastica = new Elastica_Client();
$index = $elastica->getIndex($config->location->airportCode);
$type = $index->getType('beer');

$queryTerm = new Elastica_Query_Term();
$field = 'style.untouched';
$term = 'American-Style Stout';
$queryTerm->setTerm($field, $term);

$query = new Elastica_Query($queryTerm);

$results = $type->search($query);

echo "<pre>";
print_r($results);