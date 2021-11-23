<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: /login?returnToUrl=' .  urlencode($_SERVER["REQUEST_URI"]));
    exit;
}
require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/core/bootstrap.php';
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;
use ProyectoWeb\app\controllers\admin\AdminController;
use ProyectoWeb\app\controllers\admin\CategoryController;
use ProyectoWeb\app\controllers\admin\ProductController;
use ProyectoWeb\core\App;


$app = new \Slim\App(APP::get('config')['slim']);

$container = $app->getContainer();

$templateVariables = [
    "basePath" =>  $container->request->getUri()->getBasePath()
];
$container['renderer'] = new PhpRenderer("../../src/app/views/admin/", $templateVariables);

$app->get('/', AdminController::class . ':home')->setName("home");
$app->get('/categorias', CategoryController::class . ':home')->setName("categorias");
$app->get('/productos', ProductController::class . ':home')->setName("productos");

$app->run();
