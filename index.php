<!DOCTYPE html>
<html>
<head>
    <title>Formulario autentificación</title>
    <link rel="stylesheet" href="./style/bootstrap.min.css">
    <link rel="stylesheet" href="./style/style.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: #3494E6;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #EC6EAD, #3494E6);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #EC6EAD, #3494E6); 

        }
    </style>
</head>
<body>
<div class="container my-3">
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 py-4 mx-auto bg-white" >
            <h2>Iniciar Sesión</h2>
            <form action="dologin.php" method="POST">
                <div class="mb-3 col-11 mx-auto">
                    <label for="username">Nombre usuario</label>
                    <input type="text" class="form-control" name="username" placeholder="Teclee el usuario o email" autofocus>
                </div>
                <div class="mb-3 form-group col-11 mx-auto">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" name="password" placeholder="Ingrese su contraseña">
                </div>
                <div class="form-group col-11 mx-auto">
                <?php
                    require_once("./config/configDB.php");
                    require_once("./config/p1_lib.php");
                    require_once("./appdata/p1/usuarios.php");
       
                    
                    $conn = get_connection();
                    $e = isset($_GET["e"]) ? $_GET["e"]: null ;

                    if(isset($_SESSION["id"])){
                    $usuario = Usuarios::getById($conn, $_SESSION["id"]);
                    if(isset($_SESSION["username"]) && isset($_SESSION["pass"]) && $usuario->ESTADO == 0){
                        header("location:home.php");
                        exit;
                    }
                }
                    if(!$e == null){
                    echo "<p style = 'color:red; font-size:1.2em'>$ERRORES[$e]</p>";
                    }
                ?>
                <a href="dologin.php">
                <br>
                    <button type="submit" class="btn btn-primary btn-lg btn-block boton">Iniciar sesión</button>
                </a>
                <a href="signup.php"> 
                    <button style="color:white" type="button" class="btn btn-info btn-lg btn-block boton">Quiero registrarme</button>
                </a>
                </div>
            </form>
        </div> 
    </div>
</div>
</body>
</html>
