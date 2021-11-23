<?php
    if (!isset($_SESSION['username'])) {
      header('location: /login?returnToUrl=/galeria');
    }
    $title = "Galería";
    require_once __DIR__ . "/../../utils/utils.php";
    use ProyectoWeb\core\App;
    use ProyectoWeb\Forms\TextareaElement;
    use ProyectoWeb\Forms\LabelElement;
    use ProyectoWeb\Forms\ButtonElement;
    use ProyectoWeb\Forms\FileElement;
    use ProyectoWeb\Forms\FormElement;
    use ProyectoWeb\Forms\SelectElement;
    use ProyectoWeb\Forms\OptionElement;
    use ProyectoWeb\Forms\custom\MyFormControl;
    use ProyectoWeb\Forms\Validator\NotEmptyValidator;
    use ProyectoWeb\Forms\Validator\MimetypeValidator;
    use ProyectoWeb\Forms\Validator\MaxSizeValidator;
    use ProyectoWeb\entity\ImagenGaleria;
    use ProyectoWeb\repository\ImagenGaleriaRepository;
    use ProyectoWeb\repository\CategoriaRepository;
    require_once __DIR__ . "/../../utils//SimpleImage.php";
    
    $info = $urlImagen = "";

    $description = new TextareaElement('descripcion', 'descripcion');
    $description
     ->setValidator(new NotEmptyValidator('La descripción es obligatoria', true));
    $descriptionWrapper = new MyFormControl($description, 'Descripción', 'col-xs-12');

    $fv = new MimetypeValidator(['image/jpeg', 'image/jpg', 'image/png'], 'Formato no soportado', true);
    
    $fv->setNextValidator(new MaxSizeValidator(2 * 1024 * 1024, 'El archivo no debe exceder 2M', true));
    $file = new FileElement('imagen', 'imagen');
    $file
      ->setValidator($fv);

    $labelFile = new LabelElement('Imagen', $file);

    $repositorio = new ImagenGaleriaRepository();
    $repositorioCategoria = new CategoriaRepository();

    $categoriasEl = new SelectElement('categoria', false);

    $categorias = $repositorioCategoria->findAll();
    foreach ($categorias as $categoria) {
      $option = new OptionElement($categoriasEl, $categoria->getNombre());

      $option->setDefaultValue( $categoria->getId());
      
      $categoriasEl->appendChild($option);
    }
   
    $categoriaWrapper = new MyFormControl($categoriasEl, 'Categoría', 'col-xs-12');
    $b = new ButtonElement('Send', '', '', 'pull-right btn btn-lg sr-button', '');

    $form = new FormElement('', 'multipart/form-data');
    $form
    ->setCssClass('form-horizontal')
    ->appendChild($labelFile)
    ->appendChild($file)
    ->appendChild($descriptionWrapper)
    ->appendChild($categoriaWrapper)
    ->appendChild($b);

    
    if ("POST" === $_SERVER["REQUEST_METHOD"]) {
        $form->validate();
        if (!$form->hasError()) {
          try {
            $file->saveUploadedFile(APP::get('rootDir') . ImagenGaleria::RUTA_IMAGENES_GALLERY);  
              // Create a new SimpleImage object
              $simpleImage = new \claviska\SimpleImage();
              $simpleImage
              ->fromFile(ImagenGaleria::RUTA_IMAGENES_GALLERY . $file->getFileName())  
              ->resize(975, 525)
              ->toFile(ImagenGaleria::RUTA_IMAGENES_PORTFOLIO . $file->getFileName())
              ->resize(650, 350)
              ->toFile(ImagenGaleria::RUTA_IMAGENES_GALLERY . $file->getFileName()); 
              $imagenGaleria = new ImagenGaleria($file->getFileName(), $description->getValue(), 0, 0, 0, intval($categoriasEl->getValue()));
              $repositorio->save($imagenGaleria);
              $info = 'Imagen enviada correctamente'; 
              $urlImagen = ImagenGaleria::RUTA_IMAGENES_GALLERY . $file->getFileName();
              $form->reset();
            
          }catch(Exception $err) {
              $form->addError($err->getMessage());
              $imagenErr = true;
          }          
        }
    }

    
    try {
      $imagenes = $repositorio->findAll();
    }catch(QueryException $qe) {
      $imagenes = [];
      echo $qe->getMessage();
      //En este caso podríamos generar un mensaje de log o parar el script mediante die($qe->getMessage())
    }
    include(__DIR__ . "/../views/galeria.view.php");