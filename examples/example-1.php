<?php
require_once '../scripts/params.php';

$elastica = new Elastica_Client();
$index = $elastica->getIndex($config->location->airportCode);
$breweryType = $index->getType('brewery');

$query = new Elastica_Query_Ids();
$query->setIds(array('pwfPCD')); //'d25euF'
$results = $breweryType->search($query);

echo "<pre>";
print_r($results);
