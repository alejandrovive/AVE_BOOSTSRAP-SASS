<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil</title>
    <link rel="stylesheet" href="./style/bootstrap.min.css">
    <link rel="stylesheet" href="./style/products.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
<?php

        require_once("./config/p1_lib.php");
        require_once("./appdata/p1/productos.php");
        require_once("./config/configDB.php");

        $e = isset($_GET["e"]) ? $_GET["e"]: null ;
        $conn = get_connection();
        $categorias = Productos::getCategory($conn);

        //var_dump($_GET["error"]);
        if(!(isset($_SESSION["username"]) && isset($_SESSION["pass"]))){
            header("location:index.php");
            exit;
        }  ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light position-relative top-0 start-0 w-100">
    <div class="container">
        <a class="navbar-brand d-lg-none" href="#">HISPANO</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse p-2 flex-column" id="navbarContent">
            <div class="d-flex justify-content-center justify-content-lg-between flex-column flex-lg-row w-100">
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Buscar" />
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="fa fa-search"></i>    
                        </button>
                </form>
                <a class="navbar-brand d-none d-lg-block" href="home.php">HISPANO</a>
                <ul class="navbar-nav">
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link mx-2" href="home.php">
                            <i class="fa fa-home"></i>Home
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link mx-2" href="myaccount.php">
                            <i class="fa fa-user" aria-hidden="true"></i>Mi cuenta
                        </a>
                    </li>
                    <?php 
                        db_usuario_admin($conn, $_SESSION["username"]);
                     ?>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link mx-2" href="logout.php">
                            <i class="fa fa-sign-out-alt" aria-hidden="true"></i>Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                <ul class="navbar d-flex justify-content-center align-items-center pt-3">
                    <li class="nav-item mx-2" style="list-style-type: none;">
                        <a class="nav-link" href="#">
                            <i class="fa fa-music" aria-hidden="true"></i>
                            Música
                        </a>
                    </li>
                    <li class="nav-item mx-2" style="list-style-type: none;">
                        <a class="nav-link" href="#">
                            <i class="fa fa-car" aria-hidden="true"></i>
                            Automóviles
                        </a>
                    </li>
                    <li class="nav-item mx-2" style="list-style-type: none;">
                        <a class="nav-link" href="#">
                            <i class="fa fa-motorcycle" aria-hidden="true"></i>
                            Motos
                        </a>
                    </li>
                    <li class="nav-item mx-2" style="list-style-type: none;">
                        <a class="nav-link" href="#">
                        <i class="fa fa-laptop" aria-hidden="true"></i> 
                            Tecnología
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<div class="container bg-light formulario" >
    <div class="row">
        <form action="uploadProduct.php" method="POST" enctype="multipart/form-data">
            <div class="col-md-12 my-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="card-title">Sobre el producto</h5>
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control" name="name" required autofocus>
                                    <select class="form-select formulario" aria-label="Default select example" id="categorySelect" name="categoria" required>
                                    <?php
                                        // Generar opciones del select
                                        if (!empty($categorias)) {
                                            foreach ($categorias as $categoria) {
                                                echo '<option value="' . $categoria->IDCATEGORIA . '" data-id="' . $categoria->IDCATEGORIA . '">' . $categoria->DESCRIPCION . '</option>';                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="form-group my-3 mb-2">
                                    <label for="descripcion" >Descripción del producto</label>
                                    <textarea class="form-control my-2 mb-2" name="descripcion" rows="3"></textarea>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="card-title">Categorías</h5>
                                <!--
                                    <label for="category">Categoría</label>
                                    <input type="text" class="form-control" name="category" value="<?php ?>">
                                    !-->
                                    <label for="price">Precio</label>
                                    <input type="number" class="form-control"  name="price" required>
                                    <select id="subcategoria" class="form-select formulario" aria-label="Default select example" name="subcategoria" min="10" max="10000" disabled required>
                                        <option selected>Selecciona una categoría primero</option>
                                    </select>
                                    <div class="form-group mb-2 my-3 mx-auto">
                                        <label for="imgProduct">Imagenes del producto</label>
                                        <input type="file" class="form-control my-2 mb-2" name="imgProduct[]" multiple required>
                                    </div> 
                                    <?php
                                        if(!$e == null){
                                                echo "<p style = 'color:red; font-size:1.2em'>$ERRORES[$e]</p>";
                                        }
                                    ?>
                            </div>
                        </div>
                        <div class="form-group my-3">
                        <a href="updateUser.php">
                            <button type="submit" class="btn btn-primary btn-lg btn-block boton">Guardar cambios</button>
                        </a>
                        <a href="home.php">
                            <button type="button" class="btn btn-info btn-lg btn-block boton" style="color:white">Volver al home</button>
                        </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
<script>document.getElementById("categorySelect").addEventListener("change", function() {
    let categoriaId = this.options[this.selectedIndex].dataset.id;
    cargarSubcategorias(categoriaId);
});

function cargarSubcategorias(categoriaId) {
    let subcategoriaSelect = document.getElementById("subcategoria");

    // Realizar la solicitud AJAX
    fetch("cargar_subcategorias.php?categoriaId=" + categoriaId)
        .then(response => response.json())
        .then(data => {
            subcategoriaSelect.innerHTML = "<option selected>Selecciona una subcategoría</option>";
            subcategoriaSelect.disabled = false;

            data.forEach(subcategoria => {
                let option = document.createElement('option');
                option.value = subcategoria.IDSUBCATEGORIA;
                option.textContent = subcategoria.DESCRIPCION; 
                subcategoriaSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
}


</div>
<?php
        $conn = null;

?>
</body>
</html>