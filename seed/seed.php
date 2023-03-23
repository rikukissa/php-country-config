<?php

require __DIR__ . '/../vendor/autoload.php';

$client = new MongoDB\Client('mongodb://localhost:27017');



$client->selectDatabase('user-mgnt')->selectCollection('users')->insertMany(json_decode(file_get_contents(__DIR__ . '/data/users/users.json')));
$client->selectDatabase('user-mgnt')->selectCollection('roles')->insertMany(json_decode(file_get_contents(__DIR__ . '/data/users/roles.json')));
$client->selectDatabase('hearth-dev')->selectCollection('Practitioner')->insertMany(json_decode(file_get_contents(__DIR__ . '/data/users/practitioners.json')));

$client->selectDatabase('hearth-dev')->selectCollection('Location')->insertMany(json_decode(file_get_contents(__DIR__ . '/data/locations/locations.json')));
$client->selectDatabase('hearth-dev')->selectCollection('Location')->insertMany(json_decode(file_get_contents(__DIR__ . '/data/locations/offices.json')));
$client->selectDatabase('hearth-dev')->selectCollection('Location')->insertMany(json_decode(file_get_contents(__DIR__ . '/data/locations/health-facilities.json')));

$client->selectDatabase('application-config')->selectCollection('configs')->insertOne(json_decode(file_get_contents(__DIR__ . '/data/application-configuration.json')));
$client->selectDatabase('application-config')->selectCollection('certificates')->insertMany(json_decode(file_get_contents(__DIR__ . '/data/certificates.json')));
