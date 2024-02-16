<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Document</title>
    <link rel='stylesheet' href='./style/bootstrap.min.css'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<?php 
        require_once('./config/p1_lib.php');
        require_once('./appdata/p1/usuarios.php');
        require_once('./appdata/p1/productos.php');
        
        $e = isset($_GET['e']) ? $_GET['e'] : null;
        define('REGISTROS_POR_PAGINA', 4);
        $conn = get_connection();
        $productos = Productos::getProducts($conn);
        $countProducts = count($productos);
        $total_paginas = ceil($countProducts / REGISTROS_POR_PAGINA);

        if (isset($_GET['pagina'])) {
            $pagina = $_GET['pagina'];
        } else {
            $pagina = 1;
        }
   
$inicio = ($pagina - 1) * REGISTROS_POR_PAGINA;
$productos_paginados = array_slice($productos, $inicio, REGISTROS_POR_PAGINA);
/*
echo '
<div class="container my-2 bg-light mt-3 p-3 ">
  <div class="row">';
  */
foreach ($productos_paginados as $producto) {
  // Obtener las imágenes asociadas al producto actual
  $fotos_productos = Productos::getAllImagenesProducto($conn, $producto->IDPRODUCTO);
  //$carousel_content = '';
  // Inicializar la variable $imagen_src con la imagen predeterminada
  $imagen_src = './img/product.png';
  /*
  echo 
  '<div id="'.$producto->IDPRODUCTO.'" class="carousel slide h-25 w-25 colum-lg-3" data-bs-ride="carousel">
  <div class="carousel-inner">
  ';
  */
  // Verificar si se recuperaron imágenes para el producto actual
  if ($fotos_productos !== null) {
      // Iterar sobre las imágenes y establecer $imagen_src con la primera imagen válida encontrada
      foreach ($fotos_productos as $foto) {
          // Verificar si la imagen es válida
          /*
            echo 
            '<div id="carouselExampleCaptions" class="carousel slide h-25 w-25 colum-lg-3" data-bs-ride="carousel">
            <div class="carousel-inner">
            ';
            */
          if ($foto !== null && $foto !== "") {
              // Si se encuentra una imagen válida, establecer $imagen_src y salir del bucle
              $imagen_src = 'data:image/jpeg;base64,' . base64_encode($foto->IMAGEN);
              /* $carousel_content .= '
                <div class="carousel-item">
                    <img src="' . $imagen_src . '" class="d-block w-100" alt="' . $producto->TITULO . '">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>' . $producto->TITULO . '</h5>
                        <p>' . $producto->DESCRIPCION . '</p>
                    </div>
                </div>';
              break;
              */
          }
      }
  }
  /*
  echo '
  <div class="container my-2 bg-light mt-3 p-3">
      <div class="row">
          <div id="carouselExampleCaptions" class="carousel slide h-25 w-25 colum-lg-3" data-bs-ride="carousel">
              <div class="carousel-inner">
                  ' . $carousel_content . '
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
              </button>
          </div>
      </div>
  </div>';
  */
  
}




    // Mostrar el producto con su imagen y otros detalles
    ?>


<div class="container my-2  mt-3 p-3">
    <div class="row">
        <?php
        // Verificar si hay menos de 4 productos
        $numProductos = count($productos_paginados);
        if ($numProductos < 4) {
            // Obtener el producto por defecto
            $productoPorDefecto = obtenerProductoPorDefecto(); // Debes implementar esta función
            // Obtener las imágenes asociadas al producto por defecto
            $fotos_productos = Productos::getAllImagenesProducto($conn, $productoPorDefecto->IDPRODUCTO);
        ?>
        <div class="card h-25 w-25 col-lg-3 col-sm-6">
            <div id="carousel_<?php echo $productoPorDefecto->IDPRODUCTO; ?>" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    // Iterar sobre las imágenes del producto por defecto para crear los elementos del carousel
                    foreach ($fotos_productos as $index => $foto) {
                    ?>
                    <div class="carousel-item <?php if ($index === 0) echo 'active'; ?>">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($foto->IMAGEN); ?>" class="d-block w-100" alt="Slide">
                    </div>
                    <?php } ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel_<?php echo $productoPorDefecto->IDPRODUCTO; ?>" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel_<?php echo $productoPorDefecto->IDPRODUCTO; ?>" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="card-body">
                <h5 class="card-text fw-bold"><?php echo $productoPorDefecto->TITULO; ?></h5>
                <small class="text-secondary"><h5><?php echo $productoPorDefecto->PRECIO; ?>€</h5></small>
                <h6 class="text-secondary"><?php echo $productoPorDefecto->DESCRIPCION; ?></h6>
                <button type="button" class="btn btn-primary opacity-100">Comprar</button>
            </div>
        </div>
        <?php
        }
        // Iterar sobre los productos paginados
        foreach ($productos_paginados as $producto) {
            // Si hay menos de 4 productos, ya hemos mostrado el producto por defecto, así que lo omitimos
            if ($numProductos < 4) {
                continue;
            }
            // Obtener las imágenes asociadas al producto actual
            $fotos_productos = Productos::getAllImagenesProducto($conn, $producto->IDPRODUCTO);
        ?>
        <div class="card h-25 w-25 col-lg-3 col-sm-6">
            <div id="carousel_<?php echo $producto->IDPRODUCTO; ?>" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    // Iterar sobre las imágenes del producto para crear los elementos del carousel
                    foreach ($fotos_productos as $index => $foto) {
                    ?>
                    <div class="carousel-item <?php if ($index === 0) echo 'active'; ?>">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($foto->IMAGEN); ?>" class="d-block w-100" alt="Slide">
                    </div>
                    <?php } ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel_<?php echo $producto->IDPRODUCTO; ?>" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel_<?php echo $producto->IDPRODUCTO; ?>" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="card-body">
                <h5 class="card-text fw-bold"><?php echo $producto->TITULO; ?></h5>
                <small class="text-secondary"><h5><?php echo $producto->PRECIO; ?>€</h5></small>
                <h6 class="text-secondary"><?php echo $producto->DESCRIPCION; ?></h6>
                <button type="button" class="btn btn-primary opacity-100">Comprar</button>
            </div>
        </div>
        <?php } ?>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>