<?php
namespace ProyectoWeb\app\controllers;

use Psr\Container\ContainerInterface;


class PageController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
    public function home($request, $response, $args) {
        $title = "Inicio";
        return $this->container->renderer->render($response, "index.view.php", compact('title'));
        
   }

}
