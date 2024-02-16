<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil</title>
    <link rel="stylesheet" href="./style/bootstrap.min.css">
    <link rel="stylesheet" href="./style/myaccount.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
<?php

        require_once("./config/p1_lib.php");
        require_once("./appdata/p1/usuarios.php");

        $e = isset($_GET["e"]) ? $_GET["e"]: null ;
        $conn = get_connection();
        //$user = db_get_usuario($conn, $_SESSION["username"], $_SESSION["pass"], $e);
        $idUsuario = $_SESSION["id"];
        $usuario = Usuarios::getById($conn, $idUsuario);
        $foto = $usuario->AVATAR;
        //var_dump($_GET["error"]);
        if(!(isset($_SESSION["username"]) && isset($_SESSION["pass"])) || $usuario->ESTADO==1){
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
                        <a class="nav-link mx-2" href="products.php">
                            <i class="fa fa-upload" aria-hidden="true"></i>Subir Producto
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
        <form action="updateUser.php" method="POST" enctype="multipart/form-data">
            <div class="col-md-12 my-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                        <div class="col-md-2">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Información Adicional</h5>
                                        <label for="name">Nombre</label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $usuario->NOMBRE; ?>">
                                        <label for="lastname1">Primer Apellido</label>
                                        <input type="text" class="form-control" id="lastname1" name="lastname1" value="<?php echo $usuario->APELLIDO1; ?>">
                                        <label for="lastname2">Segundo Apellido</label>
                                        <input type="text" class="form-control" id="lastname2" name="lastname2" value="<?php echo $usuario->APELLIDO2; ?>">
                                        <p class="card-text">Ícono del usuario</p>
                                        <?php
                                        
                                        if($e!== null) {
                                            echo "<p style='color:red; font-size:1em'>" . $ERRORES[$e] . "</p>";
                                        } 
                                        ?>
                                        <img style="color: transparent" src='<?php 
                                        if ($foto == null || $foto == "")  {
                                            echo "./img/user.png";
                                        } else {
                                            echo 'data:image/jpeg;base64,'.base64_encode($foto);
                                        }?>' alt='Avatar' class='img-fluid'>
                                        <input tabindex='2' type='file' name='avatar' id='avatar'>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <h5 class="card-title">Usuario</h5>
                                <p class="card-text">Detalles sobre el usuario</p>
                                    <label for="username">Usuario</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $usuario->USERNAME; ?>" autofocus>
                                    <label for="date">Fecha de nacimiento</label>
                                    <input type="date" class="form-control" id="date" name="date" readonly value="<?php echo $usuario->FECHANAC; ?>">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" readonly value="<?php echo $usuario->EMAIL; ?>">
                                    <label for="location">Dirección</label>
                                    <input type="text" class="form-control" id="location" name="location" value="<?php echo $usuario->DIRECCION; ?>">
                            </div>
                            <div class="col-md-5">
                                <h5 class="card-title">Creedenciales del usuario</h5>
                                <p class="card-text">Seguridad</p>
                                    <label for="password">Contraseña actual</label>
                                    <input type="password" class="form-control" id="password" name="password" value="<?php echo $_SESSION["pass"]; ?>">
                                    <label for="passwordChange">Cambiar contraseña</label>
                                    <input type="text" class="form-control" id="passwordChange" name="passwordChange" value="">
                                    <label for="passwordAuth">Confirmar contraseña</label>
                                    <input type="text" class="form-control" id="passwordAuth" name="passwordAuth" value="">
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
</div>
<?php
        $conn = NULL;

?>
</body>
</html>