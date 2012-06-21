<?php
require_once '../scripts/bootstrap.php';

$elastica = new Elastica_Client();
$index = $elastica->getIndex($config->location->airportCode);
$type = $index->getType('brewery');

// Raleigh, NC PHP - Tek Systems (1201 Edwards Mill Rd. , Ste 201 Raleigh, North Carolina 27607)
// 35.799341,-78.728328

$latitude = 35.799341;
$longitude = -78.728328;
$distance = '5mi';

$geoDistanceFilter = new Elastica_Filter_GeoDistance(
    'brewery.location.address.geo', 
    $latitude, 
    $longitude, 
    $distance
);

$query = new Elastica_Query(
    new Elastica_Query_MatchAll()
);

$query->setFilter($geoDistanceFilter);

$results = $type->search($query);

echo "<pre>";
print_r($results);