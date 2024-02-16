<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="./style/signup-style.css">
    <link rel="stylesheet" href="./style/bootstrap.min.css">


</head>
<body>
<div class="container my-3">
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 py-4 mx-auto bg-white" >
            <h2>Registro</h2>
            <form action="dosignup.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group mb-3 col-6 mx-auto">
                        <label for="username">Nombre usuario</label>
                        <input type="text" class="form-control" name="username" placeholder="Teclee el usuario" autofocus required>
                    </div>
                    <div class="form-group mb-3 col-6 mx-auto">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" name="password" placeholder="Ingrese su contraseña" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group mb-3 col-6 mx-auto">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" name="name" placeholder = "Ingrese su nombre" required>
                    </div>
                    <div class="form-group mb-3 col-6 mx-auto">
                        <label for="passwordAuth">Confirmar contraseña</label>
                        <input type="password" class="form-control" name="passwordAuth" placeholder="Confirme su contraseña" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group mb-3 col-6 mx-auto">
                        <label for="lastname1">Apellido</label>
                        <input type="text" class="form-control" name="lastname1" placeholder = "Primer apellido" required>
                    </div>
                    <div class="form-group mb-3 col-6 mx-auto">
                        <label for="lastname2">Apellido</label>
                        <input type="text" class="form-control" name="lastname2" placeholder = "Segundo apellido (opcional)" >
                    </div>
                </div>
                    <div class="form-group mb-3 col-11 mx-auto">
                        <label for="date">Fecha de nacimiento</label>
                        <input type="date" class="form-control" name="date" required>
                    </div>
                    <div class="form-group mb-3 col-11 mx-auto">
                        <label for="email">Correo electrónico</label>
                        <input type="email" class="form-control" name="email" placeholder="Ingrese su correo electrónico (fórmatos válidos @iesgalileo o @gmail)" required>
                    </div>
                    <div class="form-group mb-3 col-11 mx-auto">
                        <label for="location">Dirección</label>
                        <input type="text" class="form-control" name="location" placeholder = "Ingrese su dirección (Ej: Calle xxxx nº5, Valladolid)" required >
                    </div>
                    <div class="form-group mb-3 col-11 mx-auto">
                        <label for="CP">Código postal</label>
                        <input type="text" class="form-control" name="CP" placeholder = "Código Postal (Ej: Calle 01234)" required >
                    </div>
                    <div class="form-group mb-3 col-11 mx-auto">
                        <label for="avatar">Avatar</label>
                        <input type="file" class="form-control" name="avatar">
                    </div>
                
                    <div class="form-group col-11 mx-auto">
                    <?php
                        require_once("./config/configDB.php");
                        require_once("./config/p1_lib.php");
                        $e = isset($_GET["e"]) ? $_GET["e"]: null ;
                        $err = isset($_GET["err"]) ? $_GET["err"]: null ;
                        if(!$e == null){
                        echo "<p style = 'color:red; font-size:1.2em'>$ERRORES[$e]</p>";
                        } else if (!$err == null) {
                            echo "<p style = 'color:red; font-size:1.2em'>$ERROR_FILE[$err]</p>";
                        }
    
                    ?>
                    <a href="dosignup.php">
                        <button type="submit" class="btn btn-primary btn-lg btn-block boton">Registrar</button>
                    </a>
                    <a href="index.php"> 
                        <button type="button" style="color:white" class="btn btn-info btn-lg btn-block boton">Quiero iniciar sesión</button>
                    </a>
                    </div>
            </form>
        </div> 
    </div>
</div>
</body>
</html>