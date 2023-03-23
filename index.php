<?php
require_once 'fhir.php';

require __DIR__ . '/vendor/autoload.php';
$router = new \Bramus\Router\Router();

/*
 * Serves the configuration for OpenCRVS Client
 */

$router->get('/client-config.js', function () {
  header('Content-Type: text/javascript');
  $content = file_get_contents('static/client-config.js');
  echo $content;
});

/*
 * Serves the configuration for OpenCRVS Login
 */

$router->get('/login-config.js', function () {
  header('Content-Type: text/javascript');
  $content = file_get_contents('static/login-config.js');
  echo $content;
});

/*
 * Serves translations for the OpenCRVS Application
 */

$router->get('/content/client', function () {
  header('Content-Type: application/json');
  $content = file_get_contents('static/localisation/client.json');
  echo $content;
});

/*
 * Serves translations for the OpenCRVS Login Application
 */

$router->get('/content/login', function () {
  header('Content-Type: application/json');
  $content = file_get_contents('static/localisation/login.json');
  echo $content;
});


/*
 * This handler can validate incoming birth registrations and generate registrationNumbers for them
 * After the validation is done (note that there's no validation at the moment),
 * this function send a confirmation message back to OpenCRVS (http://localhost:5001/confirm/registration)
 *
 * Note, that
 * sendRegistrationConfirmation -> findTaskIdentifier implementation is too naive to handle death / marriage for now :)
 */

$router->post('/validate/registration', function () use ($router) {
  header('Content-Type: application/json');
  $body = json_decode(file_get_contents("php://input"), true);
  echo json_encode(sendRegistrationConfirmation($body));
});

/*
 * This function generates a registration number for the birth registration
 * and sends it back to OpenCRVS. Tracking ID is used to tell OpenCRVS which
 * registration the registration number belongs to
 */
function sendRegistrationConfirmation($bundle)
{
  $url = 'http://localhost:5001/confirm/registration';
  $payload = [
    'trackingId' => findTaskIdentifier($bundle),
    'registrationNumber' => generateRandomString()
  ];
  $data_string = json_encode($payload);

  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

  curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: ' . $_SERVER['HTTP_AUTHORIZATION'],
    'Content-Length: ' . strlen($data_string)
  ]);

  $response = curl_exec($curl);
  $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

  curl_close($curl);

  return [
    'status' => $http_status,
    'response' => $response
  ];
}


/*
 * Enable CORS
 */
$router->options('/.*', function () {
  header('Access-Control-Allow-Headers: *');
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: *');
});

$router->before('GET|OPTIONS', '/.*', function () {
  header('Access-Control-Allow-Headers: *');
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: *');
});

/*
 * Start the server
 */
$router->run();
