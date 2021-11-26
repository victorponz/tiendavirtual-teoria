---
typora-copy-images-to: assets
---

Vamos a implementar el listado de productos por categoría.

Como siempre, nos hace falta:

* definir una ruta
* crear un método en el repositorio
* crear el controlador
* crear la vista 
* crear el partial.

# 3.1 Ruta

![1547023385886](assets/1547023385886.png)

## `ProductRepository`

![1547023404422](assets/1547023404422.png)

## `CategoryController`

![1547023425991](assets/1547023425991.png)

> **NOTA**. Se llama `$categoriaActual` y no `$categoria`porque en el partial `category.part.php` ya usamos una variable con el mismo nombre.

## `categoria.view.php`

```php
<?php
  include __DIR__ . "/partials/inicio-doc.part.php";
  include __DIR__ . "/partials/productos.part.php";
  include __DIR__ . "/partials/fin-doc.part.php";
?>
```

## `productos.part.php`

```php+HTML
<div class="row">
    <h2 class='subtitle'><?= $categoriaActual->getNombre()?></h2>
    <?php
    foreach($productos as $producto){
        include "thumbnail-producto.part.php";
    }
    ?>
</div>
```

## Crear el enlace a las categorías

Ahora nos hace falta modificar el enlace asociado en el menú de categorías. Para ello volvemos a hacer uso del enrutador en `category.part.php`

```php
 href="<?=$router->pathFor('categoria', 
            ['nombre' =>  ProyectoWeb\app\utils\Utils::encodeURI($categoria->getNombre()), 'id' => $categoria->getId()])?>"
```



# 3.2 Paginador

Vamos a incluir un paginador para los productos:

![1546976638993](assets/1546976638993.png)



Para ello nos hace falta:

* modificar la ruta
* un componente paginador, que necesita
  * conocer la página actual
  * conocer el número total de productos de la categoría
  * conocer cuántos productos listamos en cada categoría
  * conocer la ruta a cada página
* modificar el repositorio
* un partial para el paginador
* modificar la vista

## Ruta

Modificamos la ruta para que ahora incluya la página como un parámetro. Va ser del estilo: `/categoria/flores/1/page/2`

Por tanto, 

![1547023758677](assets/1547023758677.png)

Fijaos en:

```php
[/page/{currentPage:[0-9]+}]
```

Cuando una parámetro va entre corchetes significa que es opcional.

## Paginador

Vamos a usar el siguiente paginador: https://github.com/jasongrimes/php-paginator

Como bien indica, para instalarlo:

```
composer require "jasongrimes/paginator"
```

 Este paginador se crea de la siguiente forma:

```php
$paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
```

Por lo que hemos de crear un método en `ProductRepository` para obtener el número total de productos, `$totalItems`, de una categoría.

![1547023782756](assets/1547023782756.png)

En este caso el método de devolución de resultados ya no es `\PDO::FETCH_CLASS` sino `\PDO::FETCH_ASSOC` porque no queremos que nos devuelva objetos sino un array asociativo.

`$itemsPerPage` vamos a definirlo en el archivo de configuración `config.php` y en `config-sample.php`. 

```diff
//Está en formato diff
@@ -15,5 +15,6 @@ return [
         'settings' => [
             'displayErrorDetails' => true //False en produccción
         ],
-    ]
+    ],
+    'itemsPerPage' => 3
 ];
```

 `$currentPage`lo obtenemos a partir del parámetro que nos inyecta el enrutador en `CategoryController::listado` :

```php
$currentPage = ($currentPage ?? 1);
```

Por último, ya sólo nos queda generar `$urlPattern`. En el ejemplo la especifica de la siguiente manera:

```php
$urlPattern = '/foo/page/(:num)';
```

Porque el paginador reemplaza `(:num)`por el número de página real. En nuestro caso va a ser (lo usaremos más adelante)

```php
$this->container->router->pathFor('categoria', 
                                  ['nombre' =>  \ProyectoWeb\app\utils\Utils::encodeURI($categoriaActual->getNombre()),
                                   'id' => $categoriaActual->getId()
                                  ]) .
    							  '/page/(:num)';
```

De esta forma, los enlaces a las páginas de la categoría flores serán de la siguiente forma:

```
/categoria/flores/1/page/1
/categoria/flores/1/page/2
/categoria/flores/1/page/3
```

## Consulta SQL

Se ha de modificar la consulta para que ahora nos vaya trayendo páginas en vez de todos los productos:

![1547024387029](assets/1547024387029.png)

## Partial para el paginador

Este es muy sencillo. De momento vamos a usar el que viene por defecto:

![1546975525385](assets/1546975525385.png)

El partial lo llamamos `pager.part.php` 

```php
<?=$paginator?>
```

## Modificamos la vista 

Incluimos el partial en la vista `categoria.view.php`:

```php
<?php
  include __DIR__ . "/partials/inicio-doc.part.php";
  include __DIR__ . "/partials/productos.part.php";
  include __DIR__ . "/partials/pager.part.php";
  include __DIR__ . "/partials/fin-doc.part.php";
?>
```

## Pasos finales

Ya podemos acabar el controlador:

![1547024407330](assets/1547024407330.png)

## Mejora del paginador

Modificamos el partial para que el paginador sea de la siguiente forma:

![1546975749734](assets/1546975749734.png)

Simplemente he usado uno de los ejemplos que ya vienen preinstalados, `pager.phtml`,  y lo he modificado un poco. Así que `pager.part.php` queda como sigue:

```php
<?php if ($paginator->getNumPages() > 1): ?>
    <ul class="pagination">
        <?php if ($paginator->getPrevUrl()): ?>
            <li><a href="<?php echo $paginator->getPrevUrl(); ?>">&laquo; Anterior</a></li>
          <?php else: ?>
              <li class="disabled"><a href="#">&laquo; Anterior</a></li>
        <?php endif; ?>

        <?php foreach ($paginator->getPages() as $page): ?>
            <?php if ($page['url']): ?>
                <li <?php echo $page['isCurrent'] ? 'class="active"' : ''; ?>>
                    <a href="<?php echo $page['url']; ?>"><?php echo $page['num']; ?></a>
                </li>
            <?php else: ?>
                <li class="disabled"><span><?php echo $page['num']; ?></span></li>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php if ($paginator->getNextUrl()): ?>
            <li><a href="<?php echo $paginator->getNextUrl(); ?>">Siguiente &raquo;</a></li>
        <?php else: ?>
            <li class="disabled"><a href="#">Siguiente &raquo;</a></li>
        <?php endif; ?>
    </ul>
<?php endif; ?>
```

------

**Credits.**

Víctor Ponz victorponz@gmail.com

Este material está licenciado bajo una licencia [Creative Commons, Attribution-NonCommercial-ShareAlike](https://creativecommons.org/licenses/by-nc-sa/3.0/)

![](https://licensebuttons.net/l/by-nc-sa/3.0/88x31.png)