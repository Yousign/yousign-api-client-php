<?php

require_once __DIR__.'/../vendor/autoload.php';

use Yousign\Authentication;
use Yousign\ClientFactory;
use Yousign\Environment;

// Values to replace
$apikey     = 'B3htk2MVMx6htXwN5gu1m4WVptsG5W91IdQuFGbWytvm4H0rOs';
$login      = 'kevin.auvinet129@yopmail.com';
$password   = Authentication::buildHashedPassword('streeter94');

$authentication = new Authentication($apikey, $login, $password);

$factory = new ClientFactory(new Environment(Environment::DEMO), $authentication);
$client = $factory->createClient();
