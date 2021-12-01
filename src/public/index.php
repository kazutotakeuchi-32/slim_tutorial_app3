<?php

// @see https://github.com/php-fig/http-message/blob/master/docs/PSR7-Interfaces.md
// @see https://www.php-fig.org/psr/psr-7/#psrhttpmessageserverrequestinterface
use \Psr\Http\Message\ServerRequestInterface as Request;

// @see https://www.php-fig.org/psr/psr-7/#psrhttpmessageresponseinterface
use \Psr\Http\Message\ResponseInterface as Response;

// @see https://github.com/slimphp/PHP-View
// use Slim\Views\PhpRenderer;

require '../../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__. "/../../")->load();



// 構成設定
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = $_ENV['DB_HOST'];
$config['db']['user']   = $_ENV['DB_USERNAME'];
$config['db']['pass']   = $_ENV['DB_PASSWORD'];
$config['db']['dbname'] = $_ENV['DB_DATABASE'];


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

// // pdo
$container['db'] = function ($c) {
  $db = $c['settings']['db'];
  $dsn = "mysql:dbname={$db['dbname']};host={$db['host']};charset=utf8mb4";
  $pdo = new PDO($dsn, $db['user'],$db['pass']);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  return $pdo;
};

// $container['db'] = function ($c) {
//   $db = $c['settings']['db'];
//   $dsn = 'mysql:host=%s;dbname=%s;charset=utf8mb4;';
//   $pdo = new PDO(sprintf($dsn, $db['host'], $db['dbname'],$db['user'],$db['pass']));
//   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//   var_dump($db);
//   return $pdo;
// };

// view

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

// ユーザ一覧
$app->get("/users", function(Request $request, Response $response, array $args) {
  try {
    $sql = "SELECT * FROM users";
    $this->db;
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll();
    $response->getBody()->write(json_encode($users));
    return $response;
  } catch (\Throwable $th) {
    $this->logger->error($th->getMessage());
    throw $th;
  }
});

//単一ユーザ
$app->get("/users/{id}", function(Request $request, Response $response, array $args){
  try {
    $id = (int)$args['id'];
    $sql = "SELECT * FROM users WHERE id = {$id}";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $user = $stmt->fetch();
    $response->getBody()->write(json_encode($user));
    return $response;
  }catch (\Throwable $th) {
    $this->logger->error($th->getMessage());
    throw $th;
  }
});
// ユーザ追加
$app->post("/users", function(Request $request, Response $response, array $args){
  try {
    $firstname = $request->getParsedBody()['firstname'];
    $lastname = $request->getParsedBody()['lastname'];
    $email = $request->getParsedBody()['email'];
    $age = $request->getParsedBody()['age'];
    $location = $request->getParsedBody()['location'];
    var_dump($firstname, $lastname, $email, $age, $location);
    $sql = "INSERT INTO users (firstname, lastname, email, age, location ) VALUES ( '$firstname', '$lastname', '$email', $age, '$location')";
    $res = $this->db->prepare($sql)->execute();
    $response->getBody()->write(json_encode($res));
    return "";
  } catch (\Throwable $th) {
    $this->logger->error($th->getMessage());
    throw $th;
  }
});

// ユーザ編集
$app->put("/users/{id}", function( Request $request, Response $response, array $args){
  try {
    $id = (int)$args['id'];
    $firstname = $request->getParsedBody()['firstname'];
    $lastname = $request->getParsedBody()['lastname'];
    $email = $request->getParsedBody()['email'];
    $age = $request->getParsedBody()['age'];
    $location = $request->getParsedBody()['location'];

    $sql = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', email = '$email', age = $age, location = '$location' WHERE id = $id";
    $res = $this->db->prepare($sql)->execute();
    $response->getBody()->write(json_encode($res));
    return $response;

  } catch (\Throwable $th) {
    $this->logger->error($th->getMessage());
    throw $th;
  }
});

// ユーザ削除
$app->delete("/users/{id}", function(Request $request, Response $response, array $args){
  try {
    $id = (int)$args['id'];
    $sql = "DELETE FROM users WHERE id = $id";
    $res = $this->db->prepare($sql)->execute();
    $response->getBody()->write(json_encode($res));
    return $response;
  }catch(\Throwable $th){
    $this->logger->error($th->getMessage());
    throw $th;
  }
});



$app->run();


