<?php

// Example for get details of a cosignature
// All api details are here : http://developer.yousign.fr/#api-2_Signature-getInfosFromCosignatureDemand

require_once __DIR__.'/bootstrap.php';

// Get the five latest cosignatures
$cosignatures = $client->getListCosign([
    'firstResult' => 0,
    'count' => 5
]);

// Convert result into array if the result is not array (example: if there is one result returned)
if (!is_array($cosignatures)) {
    $cosignatures = [$cosignatures];
}

// If no cosignature found, display an error
if (0 === \count($cosignatures)) {
    echo 'No cosignatures found';

    exit;
}

// Get details for the first cosignature of the list
$cosignature = $client->getInfosFromCosignatureDemand([
    'idDemand' => $cosignatures[0]->cosignatureEvent
]);

var_dump($cosignature);
