<?php
namespace ProyectoWeb\app\controllers\admin;

use Psr\Container\ContainerInterface;
use ProyectoWeb\core\App;

class ProductController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
    public function home($request, $response, $args) {
        $pageheader = "Productos";
        
        return $this->container->renderer->render($response, "productos.view.php", compact('pageheader'));
        
   }
 


}
