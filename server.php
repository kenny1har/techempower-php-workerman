<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/fortune.php';
require_once __DIR__ . '/dbraw.php';
require_once __DIR__ . '/updateraw.php';
use Workerman\Worker;
use Workerman\Protocols\Http;

$pdo = new PDO('mysql:host=TFB-database;dbname=hello_world;charset=utf8', 'benchmarkdbuser', 'benchmarkdbpass', array(
  PDO::ATTR_PERSISTENT => true
));

$http_worker = new Worker("http://0.0.0.0:8080");
$http_worker->count = 8;
$http_worker->onMessage = function($connection, $data)
{
  if ($_SERVER['REQUEST_URI'] == '/fortune.php') {
    ob_start();
    fortune($pdo);
    $connection->send(ob_get_clean());
  } else if ($_SERVER['REQUEST_URI'] == '/dbraw.php') {
    ob_start();
    fortune($pdo);
    $connection->send(ob_get_clean());
  } else if ($_SERVER['REQUEST_URI'] == '/updateraw.php') {
    ob_start();
    updateraw($pdo);
    $connection->send(ob_get_clean());
  } else if ($_SERVER['REQUEST_URI'] == '/plaintext.php') {
    Http::header("Content-type: text/plain");
    $connection->send('Hello, World!');
  } else if ($_SERVER['REQUEST_URI'] == '/json.php') {
    Http::header("Content-type: application/json");
    $connection->send(json_encode(['message'=>'Hello, World!']));
  }
};

Worker::runAll();
