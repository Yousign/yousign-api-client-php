[![Build Status](https://travis-ci.com/Yousign/yousign-api-client-php.svg?branch=client-v2)](https://travis-ci.com/Yousign/yousign-api-client-php)

# Yousign API client v1 for PHP

This client is for the api v1 of Yousign and don't use Nusoap

Simple example for download file :

```php
require_once __DIR__.'/vendor/autoload.php';

use Yousign\Authentication;
use Yousign\ClientFactory;
use Yousign\Environment;

$apikey = '<apikey>';
$login = '<login>';
$password = Authentication::buildHashedPassword('<password>');

$authentication = new Authentication($apikey, $login, $password);

$factory = new ClientFactory(new Environment(Environment::PROD), $authentication);
$client = $factory->createClient();

$result = $client->getCosignedFilesFromDemand(array(
    'idDemand' => 523020,
    'token' => '',
    'idFile' => 1128720
));

$dir = __DIR__.'/tmp';
if(!mkdir($dir) && !is_dir($dir, 0775)) {
    throw new \Exception('failed create tmp file');
}

file_put_contents($dir.'/result.pdf', $result->file);
```

Library in construction
