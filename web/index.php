<?php

require('../vendor/autoload.php');
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

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$conn = new mysqli($server, $username, $password, $db);

$json = file_get_contents('php://input');
$action = json_decode($json, true);

if (isset($action['data']['messages'][0]['message']['extendedTextMessage']['text'])){
    $textMessage = $action['data']['messages'][0]['message']['extendedTextMessage']['text'];

// sql to create table
    $sql = "INSERT INTO webhook_data (data, number)
VALUES ('$textMessage', '$json')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
