<?php

// Example for create a cosignature with one cosigner and two files
// All api details are here : http://developer.yousign.fr/#api-2_Signature-initCosign

require_once __DIR__.'/bootstrap.php';

$lstCosignedFile = [
    // Document with a visible signature
    [
        'name' => 'document1.pdf',
        'content' => file_get_contents(__DIR__.'/documents/document1.pdf'),
        'visibleOptions' => [
            'visibleSignaturePage' => 1,
            'isVisibleSignature' => true,
            'visibleRectangleSignature' => '384,54,543,127',
            'mail' => 'jean.dupont@yousign.fr',
            'reason' => 'Signed by Jean Dupont'
        ]
    ],
    // Document without visible signature
    [
        'name' => 'document2.pdf',
        'content' => file_get_contents(__DIR__.'/documents/document2.pdf'),
    ]
];

$lstCosignerInfos = [
    [
        'firstName' => 'Jean',
        'lastName' => 'Dupont',
        'mail' => 'jean.dupont@yousign.fr',
        'phone' => '+33612345678'
    ]
];

$result = $client->initCosign(array(
    'lstCosignedFile' => $lstCosignedFile,
    'lstCosignerInfos' => $lstCosignerInfos,
    'title' => 'My simple cosignature',
    'mode' => 'IFRAME'
));

// The query result will display into a stdClass object
var_dump($result);
