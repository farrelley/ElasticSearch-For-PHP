<?php
require_once 'params.php';
require_once '../includes/guzzle.phar';

use Guzzle\Http\Client;

$client = new Client('http://api.brewerydb.com/v2/');

$params = array(
    'key' => $config->key,
    'lat' => $config->location->lat,
    'lng' => $config->location->lng,
    'radius' => $config->location->radius,
);

$request = $client->get('search/geo/point?' . http_build_query($params));
$response = $request->send();

$data = $response->getBody();

$locations = json_decode($data);

foreach ($locations->data as $location) {

    // Get all breweries
    $breweries = array(
        'id'          => $location->brewery->id,
        'name'        => $location->brewery->name,
        'established' => $location->brewery->established,
        'isOrganic'   => $location->brewery->isOrganic,
    );

    // Get all brewery Locations
    $breweryLocations = array(
        'id'            => $location->id, 
        'streetAddress' => $location->streetAddress,
        'locality'      => $location->locality,
        'regon'         => $location->region,
        'postalCode'    => $location->postalCode,
        'latitude'      => $location->latitude,
        'longitude'     => $location->longitude,
        'inPlanning'    => $location->inPlanning,
        'isClosed'      => $location->isClosed,
        'openToPublic'  => $location->openToPublic,
        'breweryId'     => $location->brewery->id,
    );

    // Get brewery beers.  Another API Call for each brewery
    $uri = "brewery/" . $location->brewery->id . "/beers";
    echo $uri;

    $params = array(
        'key' => $config->key,
    );
    $beerRequest = $client->get($uri . "?" . http_build_query($params));
    $beerResponse = $beerRequest->send();
    $data = $beerResponse->getBody();

    $beers = json_decode($data);

    foreach ($beers->data as $beer) {
        var_dump($beer);
        $breweryBeers[] = array(
            'id' => $beer->id,
            'name' => $beer->name,
            'abv' => $beer->abv,
            'style' => $beer->style->name,
            'breweryId' => $location->brewery->id
        );
    }
}