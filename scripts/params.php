<?php
$config = new stdClass();

$config->elastica = "../elastica/lib/";
$config->key = "acd6d75e17a5a5311c5eec7167f2b7f2";
$config->location->radius = 20;

// La Crosse, WI
//$config->location->airportCode = "LSE"
// $config->location->lat = "43.8011";
// $config->location->lng = "-91.1677";`

// Raleigh, NC
$config->location->airportCode = "rdu";
$config->location->lat = "35.7719";
$config->location->lng = "-78.6389";

// Dallas, TX
// $config->location->airportCode = "DFW"
// $config->location->lat = "33.0008";
// $config->location->lng = "-96.8345";

function __autoload_elastica ($class) {
    $path = str_replace('_', '/', $class);

    if (file_exists('/PintLabs/www/ElasticSearch-For-PHP/elastica/lib/' . $path . '.php')) {
        require_once('/PintLabs/www/ElasticSearch-For-PHP/elastica/lib/' . $path . '.php');
    }
}
spl_autoload_register('__autoload_elastica');