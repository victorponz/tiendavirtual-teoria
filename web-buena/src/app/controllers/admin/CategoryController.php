<?php
namespace ProyectoWeb\app\controllers\admin;

use Psr\Container\ContainerInterface;
use ProyectoWeb\core\App;

class CategoryController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
    public function home($request, $response, $args) {
        $pageheader = "Categorías";
        
        return $this->container->renderer->render($response, "categorias.view.php", compact('pageheader'));
        
   }
 


}
