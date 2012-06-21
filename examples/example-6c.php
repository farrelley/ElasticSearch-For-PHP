<?php
require_once '../scripts/bootstrap.php';

$elastica = new Elastica_Client();
$index = $elastica->getIndex($config->location->airportCode);
$type = $index->getType('beer');

// Filter Term
$filterTerm = new Elastica_Filter_Term();
$filterTerm->setTerm("style.untouched", "American-Style Brown Ale");

// Facet
$facetTerms = new Elastica_Facet_Terms('style');
$facetTerms->setField('style.untouched');
$facetTerms->setFilter($filterTerm);

$query = new Elastica_Query();
$query->addFacet($facetTerms);
$query->setFilter($filterTerm);
$query->setQuery(new Elastica_Query_MatchAll());

$results = $type->search($query);

echo "<pre>";
print_r($results);