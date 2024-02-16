<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style/bootstrap.min.css">
    <link rel="stylesheet" href="./style/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

</head>
<body>
<?php
        require_once("./config/p1_lib.php");
        $admin = $_SESSION["perfil"];
        $e = isset($_GET["e"]) ? $_GET["e"]: null ;
        $conn = get_connection();

        if(!(isset($_SESSION["username"]) && isset($_SESSION["pass"]))){
            header("location:index.php");
            exit;
        }else if ($admin == 0){
            header("location:home.php");
            exit;
        } 
    
    ?>
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
                <a class="navbar-brand d-none d-lg-block" href="#">HISPANO</a>
                <ul class="navbar-nav">
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link mx-2" href="home.php">
                            <i class="fa fa-home"></i>Home
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link mx-2" href="myaccount.php">
                            <i class="fa fa-user"></i>Mi cuenta
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link mx-2" href="products.php">
                            <i class="fa fa-upload" aria-hidden="true"></i>Subir Producto
                        </a>
                    </li>
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
                            Musica
                        </a>
                    </li>
                    <li class="nav-item mx-2" style="list-style-type: none;">
                        <a class="nav-link" href="#">
                            <i class="fa fa-car" aria-hidden="true"></i>
                            Automoviles
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
                            Tecnologia
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<div class="container formulario" >
    <h2>Formulario</h2>
        <form action="updateAdmin.php" method="POST">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 py-4 bg-white" >
                    <div class="mb-3">
                        <label for="usernameSearch">Usuario</label>
                        <input type="text" class="form-control" id="usernameSearch"  placeholder="Teclee el usuario" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                    <div class="form-group">   
                        <button type="submit" name="post" class="btn btn-primary btn-lg btn-block boton">Guardar cambios</button>
                    </div>
            </div>
            <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 py-4 bg-white">
                <h2>Listado de usuarios</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="centrado">#</th> 
                            <th class="centrado">Nombre de usuario</th>
                            <th class="centrado">Administrador</th>
                            <th class="centrado">Permisos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php mostrarListaUsuarios($conn,$e);  ?>  
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>
</body>
</html>