<?php

require('../vendor/autoload.php');
//$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
//$dotenv->load();
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

/* Heroku remote server */
//$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
//
//$server = $url["us-cdbr-east-06.cleardb.net "];
//$username = $url["b274b1bed5a9cc"];
//$password = $url["6b5f427e"];
//$db = substr($url["mysql://b274b1bed5a9cc:6b5f427e@us-cdbr-east-06.cleardb.net/heroku_84336d314034080?reconnect=true"], 1);
//
//$conn = new mysqli($server, $username, $password, $db);

//For Local
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$conn = new mysqli($server, $username, $password, $db);
print_r($conn);
$json = file_get_contents('php://input');
$action = json_decode($json, true);

if (isset($action['data']['messages'][0]['message']['extendedTextMessage']['text'])){
    $textMessage = $action['data']['messages'][0]['message']['extendedTextMessage']['text'];

// sql to create table
    $sql = "INSERT INTO webhook_data (data, data_array)
VALUES ('$textMessage', '$json')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "INSERT INTO webhook_data (data, data_array)
VALUES ('TestData', 'TestData')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

