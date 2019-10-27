<?php

require_once __DIR__.'/../vendor/autoload.php';

use Yousign\Authentication;
use Yousign\ClientFactory;
use Yousign\Environment;

// Values to replace
$apikey     = '<apikey>';
$login      = '<login>';
$password   = Authentication::buildHashedPassword('<password>');

$authentication = new Authentication($apikey, $login, $password);

$factory = new ClientFactory(new Environment(Environment::DEMO), $authentication);
$client = $factory->createClient();
