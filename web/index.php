<?php

//require('../vendor/autoload.php');
//
//$app = new Silex\Application();
//$app['debug'] = true;
//
//// Register the monolog logging service
//$app->register(new Silex\Provider\MonologServiceProvider(), array(
//  'monolog.logfile' => 'php://stderr',
//));
//
//// Register view rendering
//$app->register(new Silex\Provider\TwigServiceProvider(), array(
//    'twig.path' => __DIR__.'/views',
//));
//
//// Our web handlers
//
//$app->get('/', function() use($app) {
//  $app['monolog']->addDebug('logging output.');
//  return $app['twig']->render('index.twig');
//});
//
//$app->get('/webhook', function() use($app) {
//    $app['monolog']->addDebug('logging output.');
//    return $app['twig']->render('webhook.php');
//});
//
//$app->run();

//Webhook Data

//$servername = "localhost";
//$username = "webhook.srisp";
//$password = "RbLHNrPjmSyfP4HD";
//$dbname = "webhook.srisp";
//
//// Create connection
//$conn = new mysqli($servername, $username, $password, $dbname);
//// Check connection
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}
$json = file_get_contents('php://input');
$action = json_decode($json, true);
if (isset($action['data']['messages'][0]['message']['extendedTextMessage']['text'])) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://webhook.site/773d0510-b1b0-4177-984c-00d2bf99ed98',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $action['data'],
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
}
//if (isset($action['data']['messages'][0]['message']['extendedTextMessage']['text'])){
//    $textMessage = $action['data']['messages'][0]['message']['extendedTextMessage']['text'];
//
//// sql to create table
//    $sql = "INSERT INTO webhook_data (data, number)
//VALUES ('$textMessage', '$json')";
//
//    if ($conn->query($sql) === TRUE) {
//        echo "New record created successfully";
//    } else {
//        echo "Error: " . $sql . "<br>" . $conn->error;
//    }
//}
