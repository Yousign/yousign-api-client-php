<?php

// Example for list your cosignatures with the search "Jean"
// All api details are here : http://developer.yousign.fr/#api-2_Signature-getListCosign

require_once __DIR__.'/bootstrap.php';

$cosignatures = $client->getListCosign([
    'search'        => 'Jean',  // Searches "Jean" into your cosignatures' list
    'firstResult'   => 0,       // Start to the first result
    'count'         => 30,      // Display 30 items
    'status'        => ''       // No status defined
]);

foreach ($cosignatures as $cosignature) {
    var_dump($cosignature);
}
