<?php
require_once '../scripts/bootstrap.php';

$elastica = new Elastica_Client();
$index = $elastica->getIndex($config->location->airportCode);
$type = $index->getType('beer');

// Query Term
$queryTerm = new Elastica_Query_Term();
$field = 'style.untouched';
$term = 'American-Style Pale Ale';
$queryTerm->setTerm($field, $term);

// Filter Term
$filterTerm = new Elastica_Filter_Term();
$filterTerm->setTerm("brewery.name", "Lonerider Brewing Company");

$query = new Elastica_Query($queryTerm);
$query->setFilter($filterTerm);

$results = $type->search($query);

echo "<pre>";
print_r($results);