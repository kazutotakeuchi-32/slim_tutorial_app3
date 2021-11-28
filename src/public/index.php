<?php

// @see https://github.com/php-fig/http-message/blob/master/docs/PSR7-Interfaces.md
// @see https://www.php-fig.org/psr/psr-7/#psrhttpmessageserverrequestinterface
use \Psr\Http\Message\ServerRequestInterface as Request;

// @see https://www.php-fig.org/psr/psr-7/#psrhttpmessageresponseinterface
use \Psr\Http\Message\ResponseInterface as Response;

// @see https://github.com/slimphp/PHP-View
// use Slim\Views\PhpRenderer;

require '../../vendor/autoload.php';


$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = 'localhost';
$config['db']['user']   = 'user';
$config['db']['pass']   = 'password';
$config['db']['dbname'] = 'exampleapp';



$app = new \Slim\App(["settings" => $config]);

// コンテナ
$container = $app->getContainer();

//monolog
$container['logger'] = function($c) {
  $logger = new \Monolog\Logger('my_logger');
  $file_handler = new \Monolog\Handler\StreamHandler('../../logs/app.log');
  $logger->pushHandler($file_handler);
  return $logger;
};
// Log::emergency($message);
// Log::alert($message);
// Log::critical($message);
// Log::error($message);
// Log::warning($message);
// Log::notice($message);
// Log::info($message);
// Log::debug($message);


// pdo

// vieq


$app->get('/', function (Request $request, Response $response, array $args) {
  $response->getBody()->write("OK");
  try {
    $this->logger->info('OK');
    return $response;
  } catch (\Throwable $th) {
    $this->logger->error($th->getMessage());
    throw $th;
  }
});

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
  $name = $args['name'];
  $response->getBody()->write("Hello, $name");
  return $response;
});

$app->get("/ticket/{id}", function (Request $request, Response $response, array $args) {
  $ticektId = (int)$args['id'];
  $response->getBody()->write("Ticket $ticektId");
  return $response;
});



$app->run();


