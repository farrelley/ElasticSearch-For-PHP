<?php
require_once '../scripts/bootstrap.php';

$elastica = new Elastica_Client();
$index = $elastica->getIndex($config->location->airportCode);
$type = $index->getType('beer');


$facetTerms = new Elastica_Facet_Terms('style');
$facetTerms->setField('style.untouched');

$query = new Elastica_Query();
$query->addFacet($facetTerms);
$query->setQuery(new Elastica_Query_MatchAll());

$results = $type->search($query);

echo "<pre>";
print_r($results);