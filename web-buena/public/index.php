<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/core/bootstrap.php';
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;
use ProyectoWeb\app\controllers\PageController;
use ProyectoWeb\app\controllers\UserController;
use ProyectoWeb\core\App;

App::bind('rootDir', __DIR__ . '/');

$app = new \Slim\App(APP::get('config')['slim']);

$container = $app->getContainer();
$templateVariables = [
    "basePath" => $container->request->getUri()->getBasePath(),
    "userName" => ($_SESSION['username'] ?? ''),
    "whitCategories" => true
];

$container['renderer'] = new PhpRenderer("../src/app/views", $templateVariables);

$app->get('/', PageController::class . ':home')->setName("home");

$app->map(['GET', 'POST'], '/login', UserController::class . ':login')->setName("login");
$app->map(['GET', 'POST'], '/register', UserController::class . ':register');
$app->get('/logout', UserController::class . ':logout');

$app->run();
