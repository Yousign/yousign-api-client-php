<?php

// Example for get details of a cosignature
// All api details are here : http://developer.yousign.fr/#api-2_Signature-getCosignedFilesFromDemand

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

// Convert into array if there is only one file
$listFiles  = $cosignatures[0]->fileInfos;
if (!is_array($listFiles)) {
    $listFiles = [$cosignatures[0]->fileInfos];
}

$result = $client->getCosignedFilesFromDemand([
    'idDemand'  => $cosignatures[0]->cosignatureEvent,
    'idFile'    => $listFiles[0]->idFile
]);

var_dump($result);
