---
typora-copy-images-to: assets
---

## 1.1 Carrusel

Vamos a crear el carrusel. Para ello es necesario:

* un método en el repositorio que nos devuelva los productos que tienen carrusel.
* modificar el controlador de la página de portada.
* hacer un partial para el carrusel.

`ProductRepository`

![1546629080812](assets/1546629080812.png)

`PageController`

![1546629104473](assets/1546629104473.png)

**Partial**

El código de `index.view.php` relativo al carrusel lo movemos a un partial `/partials/carrusel.part.php`:

```html
<div class="row carousel-holder">
   <div class="col-md-12">
      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
         <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class=""></li>
            <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
            <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
            <li data-target="#carousel-example-generic" data-slide-to="3" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="4" class=""></li>
         </ol>
         <div class="carousel-inner">
            <div class="item">
               <img class="slide-image" src="/images/carrusel/cuando-plantar-margaritas-en-el-jardin.jpg" alt="Margarita" title="Margarita">
            </div>
            <div class="item">
               <img class="slide-image" src="/images/carrusel/caracteristicas-cuidados-del-tulipan-1280x720x80xX.jpg" alt="Tulipán" title="Tulipán">
            </div>
            <div class="item">
               <img class="slide-image" src="/images/carrusel/20077.jpg" alt="Flor de pascua" title="Flor de pascua">
            </div>
            <div class="item active">
               <img class="slide-image" src="/images/carrusel/Coltivazione-Lilium-800x445.jpg" alt="Lilium" title="Lilium">
            </div>
            <div class="item">
               <img class="slide-image" src="/images/carrusel/Grow-Roses-Header-OG.jpg" alt="Rosa" title="Rosa">
            </div>
         </div>
         <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
         <span class="glyphicon glyphicon-chevron-left"></span>
         </a>
         <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
         <span class="glyphicon glyphicon-chevron-right"></span>
         </a>
      </div>
   </div>
</div>
```

Y modificamos `index.view.php` para que incluya este partial:

```php
<?php
  include __DIR__ . "/partials/inicio-doc.part.php";
  include __DIR__ . "/partials/carrusel.part.php"
?>
//Resto de código donde ya se ha eliminado el carrusels
```

Como vemos tiene dos partes: 

* Los ítems de `carousel-indicators`, donde el único valor que cambia es `data-slide-to` y `class`, que es `active` para mostrar la imagen actual.
* Las imágenes en sí, que están contenidas dentro de un `div`. El valor que cambia es el `src` de la imagen y también la clase al igual que antes.

Hacerlo dinámico es muy sencillo. 

Empezamos con `carousel-indicators`:

![1546629133706](assets/1546629133706.png)

Y continuamos con las imágenes:

![1546629148955](assets/1546629148955.png)

## 1.2 Destacados

Vamos a crear una sección en la portada con los productos destacados:

![1546626920223](assets/1546626920223.png)

Nos hace falta:

* Un método en el repositorio que nos devuelva los destacados.
* Modificar el controlador para informar la variable que usará el partial.
* Un partial para la miniatura del producto
* Un partial para destacados

`ProductRepository`

![1546629178627](assets/1546629178627.png)

`PageController`

![1546629197414](assets/1546629197414.png)

El partial `thumbnail-producto.part.php` de la miniatura es el siguiente:

```html
<div class="col-sm-4 col-lg-4 col-md-4">
    <div class="thumbnail" style="position:relative">
        <a href="#">
            <img src="/images/img_que_significan_las_margaritas_26142_orig.jpg" alt="Margarita" title="Margarita">
        </a>
        <div class="caption">
            <h4><a href="#">Margarita</a></h4>
            <p>Bellis perennis, comúnmente llamada margarita, es una planta herbácea de la familia de las asteráceas muy utilizada a efectos decorativos mezclada con el césped, por sus colores y su resistencia a la siega.</p>
        </div>
        <h4 class="pull-right"><span class="text text-danger">100,00 €</span></h4>
        <a href="#" class="btn btn-danger">Comprar</a>
    </div>
</div>
```

Que luego modificamos para que muestre los datos del producto actual.

Partial para destacados, `destacados.part.php`:

![1546629216753](assets/1546629216753.png)

Ya podemos modificar `thumbnail-producto.part.php` con los datos reales del producto:

![1546709237777](assets/1546709237777.png)

Y modificamos `index.view.php`

```php
<?php
  include __DIR__ . "/partials/inicio-doc.part.php";
  include __DIR__ . "/partials/carrusel.part.php";
  include __DIR__ . "/partials/destacados.part.php";
  include __DIR__ . "/partials/fin-doc.part.php";
?>
```

Y este es el resultado:

![1546628418271](assets/1546628418271.png)

## 1.3 Novedades

![1546629030120](assets/1546629030120.png)

Para la sección de novedades ya sólo hemos de crear:

* Un método en el repositorio que nos devuelva las novedades
* Modificar el controlador para informar la variable que usará el partial.
* Un partial para novedades

`ProductRepository`

![1546629256673](assets/1546629256673.png)

`PageController`

![1546629271544](assets/1546629271544.png)

Partial para novedades, `novedades.part.php`:

![1546629285685](assets/1546629285685.png)

Y modificar `index.view.php`

```php
<?php
  include __DIR__ . "/partials/inicio-doc.part.php";
  include __DIR__ . "/partials/carrusel.part.php";
  include __DIR__ . "/partials/destacados.part.php";
  include __DIR__ . "/partials/novedades.part.php";
  include __DIR__ . "/partials/fin-doc.part.php";
?>
```



## 1.4 Categorías

Por último, nos queda completar la lista de categorías. Sólo nos hace falta:

* inyectar las categorías a la vista
* modificar el partial

Por tanto, en `PageController`:

![1547018043426](assets/1547018043426.png)

Y modificamos el partial `category.part.php`

![1546969137066](assets/1546969137066.png)

------

**Credits.**

Víctor Ponz victorponz@gmail.com

Este material está licenciado bajo una licencia [Creative Commons, Attribution-NonCommercial-ShareAlike](https://creativecommons.org/licenses/by-nc-sa/3.0/)

![](https://licensebuttons.net/l/by-nc-sa/3.0/88x31.png)