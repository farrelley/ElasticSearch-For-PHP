<?php
require_once 'bootstrap.php';
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

    // Brewery Information
    $loc[$location->brewery->id]["brewery"] = array(
        "name"        => $location->brewery->name,
        "established" => isset($location->brewery->established) ? $location->brewery->established : null,
        "isOrganic"   => $location->brewery->isOrganic,
    );

    // Brewery Locations
    $loc[$location->brewery->id]["locations"][] = array(
        "id" => $location->id,
        "address" => array(
            "streetAddress" => isset($location->streetAddress) ? $location->streetAddress : null,
            "locality"      => $location->locality,
            "regon"         => $location->region,
            "postalCode"    => isset($location->postalCode) ? $location->postalCode : null,
            "geo" => array(
                'lat' => $location->latitude,
                'lon' => $location->longitude,
            )
        )
    );

    // Brewery Beers
    $uri = "brewery/" . $location->brewery->id . "/beers";
    $params = array(
        'key' => $config->key,
    );
    $beerRequest = $client->get($uri . "?" . http_build_query($params));
    $beerResponse = $beerRequest->send();
    $data = $beerResponse->getBody();
    $beers = json_decode($data);
    if (isset($beers->data)) {
        foreach ($beers->data as $beer) {
            $loc[$location->brewery->id]["beer"][$beer->id] = array(
                "name"    => $beer->name,
                "abv"     => isset($beer->abv) ? $beer->abv : null,
                "style"   => isset($beer->style->name) ? $beer->style->name : null,
            );
        }
    }
}


// Load up ES and get the index
$elastica = new Elastica_Client();
$index = $elastica->getIndex($config->location->airportCode);

// Get Types
$breweryType = $index->getType('brewery');
$beerType = $index->getType('beer');

foreach ($loc as $breweryId => $data) {

    // Beers
    if (!empty($data['beer'])) {
        $breweryBeer = array();
        foreach ($data['beer'] as $beerId => $beerData) {
            $breweryBeer[] = array(
                "id"   => $beerId,
                "name" => $beerData['name']
            );

            $beerDoc[] = new Elastica_Document(
                $beerId,
                array(
                    "name" => $beerData['name'],
                    "abv" => $beerData['abv'],
                    "style" => $beerData['style'],
                    "brewery" => array(
                        "id"  => $breweryId,
                        "name"  => $data['brewery']['name'],
                    )
                )
            );
        }
    }

    $breweryDocs[] = new Elastica_Document(
        $breweryId,
        array(
            "name" => $data['brewery']['name'],
            "established" => $data['brewery']['established'],
            "isOrganic" => $data['brewery']['isOrganic'],
            "location" => $data['locations'],
            "beer" => $breweryBeer,
        )
    );
}

$beerType->addDocuments($beerDoc);
$breweryType->addDocuments($breweryDocs);
