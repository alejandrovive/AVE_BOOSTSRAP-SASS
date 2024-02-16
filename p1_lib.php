<?php
require_once("configDB.php");

//Función que permita autenficar usuario pasando como parametros el usuario y la contraseña 
//(en casi todas las funciones incluiremos un error para manejar errores) 
session_start();

function get_connection() {
    // Conectar a la base de datos
    $dsn = DRIVER . ':host=' . HOST . ';dbname=' . DB; // Corregir 'db' a 'dbname'
    
    try {
        $conexion = new PDO($dsn, USER, PASSWORD);
        
        // Si la conexión se establece
        if (isset($conexion)) {
            // Recuperar información de la conexión (getAttribute)
            $version = $conexion->getAttribute(PDO::ATTR_SERVER_VERSION);
            
            
            // Establecer uno de los atributos
            $case = $conexion->getAttribute(PDO::ATTR_CASE);
            
            $conexion->setAttribute(PDO::ATTR_CASE, PDO::CASE_UPPER);
            $case = $conexion->getAttribute(PDO::ATTR_CASE);
        } else {
            echo "No se ha conectado correctamente a la base de datos";
        }
        
        return $conexion;
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        return false;
    }
}


 function registrar_usuario($conn, $usuario) {
    $hashed_password = password_hash($usuario->pass, PASSWORD_DEFAULT);
    $query = "INSERT INTO usuarios (username, pass, nombre, apellido1, apellido2, fechaNac, email, perfil, avatar, fechaCreacion, fechaModificacion, direccion, estado) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    echo $query;  

    $estado = $conn->prepare($query);
    if (!$estado) {
        die('Error en la preparación de la consulta: ' . $conn->error);
    }
    
    var_dump($estado);
    $estado->bind_param("sssssssissssi", $usuario->username, $hashed_password, $usuario->nombre, $usuario->apellido1, $usuario->apellido2, $usuario->fechaNac, $usuario->email, $usuario->perfilId, $usuario->avatar, $usuario->fechaCreacion, $usuario->fechaModificacion, $usuario->direccion, $usuario->estado);
    if (!$estado) {
        die('Error en la preparación de la consulta: ' . $conn->error);
    }
    
    var_dump($estado);
    $result = $estado->execute();
    if (!$result) {
        die('Error en la preparación de la consulta: ' . $conn->error);
    }
    
    var_dump($result);
    

    $estado->close();
    return $result;
}

function db_get_usuario($conn, $login, $password, &$e) {
    $query = "SELECT * FROM usuarios WHERE username = :login OR email = :login";
    $estado = $conn->prepare($query);
    $estado->bindParam(':login', $login, PDO::PARAM_STR);
    $estado->execute();
    $user = $estado->fetch(PDO::FETCH_OBJ);
    $estado->closeCursor();
    //$user = $estado->fetch(PDO::FETCH_ASSOC); // Obtiene la fila de resultados
    // Cerrar la sentencia preparada
    //echo var_dump($user);
    //echo $user["PASS"]; en un array!!!
    //$passSecure = $user->PASS;  //POOOOOO
    //exit;
    //$user = $estado->fetchObject('Usuario');

    if ($user && password_verify($password, $user->PASS)) {
        //idUsu y fechaHoraInicio 
        $_SESSION["username"] = $user->USERNAME;
        $_SESSION["id"] = $user->IDUSUARIO;
        $_SESSION["fechaHoraInicio"] = date("Y-m-d H:i:s");
        $_SESSION["pass"] = $password;
        return $user;
    } else {
        return 0;
    }
}

 function update_usuario($conn, $username, $password, $name, $lastname1, $lastname2, $avatar, $direccion, $id){
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $fechaModificacion = date("Y-m-d H:i:s");
    $query = "UPDATE usuarios SET username = ?, pass = ?, nombre = ?, apellido1 = ?, 
    apellido2 = ?, avatar = ?, direccion = ?, fechaModificacion = ? 
    where idUsuario = ?";
    $estado = $conn->prepare($query);
    if (!$estado) {
        die('Error en la preparación de la consulta: ' . $conn->error);
    }
    
    var_dump($estado);
    $estado->bind_param("ssssssssi", $username, $hashed_password, $name, $lastname1, $lastname2, $avatar, $direccion, $fechaModificacion, $id);

    $exito = $estado->execute(); // Ejecuta la sentencia preparada
 
    // Cerrar la sentencia preparada
    $estado->close();
    if ($exito) {        
        $_SESSION["username"] = $username;
        $_SESSION["pass"] = $password;
        return 1;
    } else {
        return 0;
    }
}


// Mostramos todos los usuarios en la parte de administrador con dos checked, uno para cambiar el administrador y otro para eliminar
function mostrarListaUsuarios2($conn, &$e){
    // Sentencia para mostrar todos los usuarios
    $query = "SELECT ID, username, perfilId FROM usuarios";
    $estado = $conn->prepare($query);
    $exito = $estado->execute();

    $result = $estado->get_result(); // Obtiene los resultados
    $user = $result->fetch_assoc();
    
    $estado->close();

            ?>
                <tr>
                    <td class="centrado"><?php echo $user["ID"];?></td>
                    <td class="centrado"><?php echo $user["username"];?></td>
                    <td class="centrado">
                    <?php
                        if ($user["perfilId"] == "1") {
                            echo '<input type="checkbox" name="admin" checked disabled>';
                        } else {
                            echo '<input type="checkbox" name="eliminar">';
                        }
                    ?>
                    </td>
                    <td class="centrado">
                        <input type="checkbox">
                    </td>
                </tr>
            <?php
            
}
 function validarExistenciaUsuario($conn, $username, &$error){
    $query = "SELECT username FROM usuarios";
    $result = $conn->query($query);

    while($registro =$result->fecth_assoc()) {
        if ($registro["username"] == $username ) {
            $error = 'AUTH_USERNAME_EXISTS';
            return 0;
        }
    }
    return 1;
 }

 function validarExistenciaEmail($conn, $email, &$error){
    $query = "SELECT email FROM usuarios";
    $result = $conn->query($query);

    while($registro =$result->fecth_assoc()) {
        if ($registro["email"] == $email ) {
            $error = 'AUTH_EMAIL_EXISTS';
            return 0;
        }
    }
    return 1;
 }
 function db_usuario_admin($conn, $login){
    $query = "SELECT perfil from usuarios WHERE username = :login OR email = :login";
    $estado = $conn->prepare($query);
    $estado->bindParam(':login', $login, PDO::PARAM_STR);
    $estado->execute(); // Ejecuta la sentencia preparada
    $user = $estado->fetch(PDO::FETCH_OBJ);
    $estado->closeCursor();

    if ($user !== null && ($user->PERFIL !=0)) {
        $_SESSION["perfil"] = $user->PERFIL;
        ?>
        <li class="nav-item d-flex align-items-center">
            <a class="nav-link mx-2" href="admin.php">
                <i class="fa fa-user-secret" aria-hidden="true"></i>Administrador
            </a>
        </li>
        <?php 
        return 1;
    } else {
        $_SESSION["perfil"] = 0; // O establece un valor predeterminado si no hay perfil
        return 0; 
    }
}




function validarUsuario($username, $email, &$error){
    if ($username === "" || $email === "") {
        $error = 'AUTH_BLANKS';
        return 0;
    } 
    
    if (!(preg_match("/^[A-Za-z0-9ñÑ]+$/", $username))) {
        $error = 'INVALID_USERNAME';
        return 0;
    }

    if (!(preg_match("/^([A-z<0-9\.-]+)@gmail\.es$/", $email) || preg_match("/^([A-z<0-9\.-]+)@iesgalileo\.es$/", $email))) {
        $error = 'EMAIL_FORMAT';
        return 0;
    }

    return 1;
    
}   

// Verifica si la contraseña es lo suficientemente segura
function validarContraseña($password, $passwordAuth, &$error){
    if ($password !== "" || $passwordAuth !== "") {
        if ($password == $passwordAuth) {
            // Comprobamos que sean carácteres alfanúmericos y que al menos tenga mayúscula, minúscula y un número
            if (preg_match("/^[A-Za-z0-9ñÑ]+$/", $passwordAuth) && (preg_match("/[0-9]+/", $passwordAuth)) 
            && (preg_match("/[A-Z]+/", $passwordAuth)) && (preg_match("/[a-z]+/", $passwordAuth))) {
                if (strlen($password) >= 5) {
                    return 1;
                } else {
                    $error = 'PASS_LEN';
                }
            } else {
                $error = 'AUTH_PASSWD';
            }
        } else {
            $error = 'PASS_FAILURE';
        }
    } else {
        $error = 'AUTH_BLANKS';
    }
    return 0;
}
//  Validamos la edad pasando la fecha a milisegundos y a la actual la restamos la fecha de nacimiento
function validarEdad($date, &$error){
    if ($date !== "") {
        $fechaActual = date('Y-m-d');
        $fechaActualNum = strtotime($fechaActual);
        $fechaNacimientoNum = strtotime($date);
        $edad = $fechaActualNum - $fechaNacimientoNum;
        // Si la edad supera o iguala los 18 años cerramos el fichero y retornamos 1
        $edad = floor($edad / (365 * 60 * 60 * 24));
        if ($edad >= 18) {
            return 1;
        } else {
            $error = 'AGE_FAILURE';
        }
    } else {
        $error = 'AUTH_BLANKS';
    }
    return 0;
}

function validarPrecio ($precio, &$error){
    $precioFloat = filter_var($precio, FILTER_VALIDATE_FLOAT);

    if ($precioFloat !== false && $precioFloat >= 1 && $precioFloat <= 10000) {
        return 1;
    } else {
        $error = 'NOT_NUMBER';
        return 0;
    }
}

function validarTextoProducto($texto, &$error){
    $expresion = '/^[a-zA-Z0-9áÁéÉíÍóÓúÚñÑ ]+$/';

    $resultado = preg_match($expresion, $texto);
    if(!$resultado) {
      $error = 'TEXT_INVALID';
      return 0;
    }
    return 1;
    
}

function mostrarListaUsuarios($conn, $e){
    // Obtener lista de usuarios desde la base de datos
    $query = "SELECT * FROM usuarios";
    $result = $conn->query($query);


    if ($result) {
        while ($user = $result->fetch(PDO::FETCH_OBJ)) {
            echo '<tr>';
            echo '<td class="centrado">' . $user->IDUSUARIO . '</td>';
            echo '<td class="centrado">' . $user->USERNAME . '</td>';
            echo '<td class="centrado">' . ($user->PERFIL == 1 ? 'Sí' : 'No') . '</td>';
            echo '<td class="centrado">';
            echo '<input type="hidden" name="userId[]" value="' . $user->IDUSUARIO . '">'; // Utilizar corchetes para obtener un array de IDs

            // Checkbox para hacer administrador
            echo '<label>';
            echo '<input type="checkbox" name="adminCheckbox[]" value="' . $user->IDUSUARIO . '"';
            // Deshabilitar el checkbox si el usuario es administrador
            if ($user->PERFIL == 1) {
                echo ' disabled';
            }
            echo '> Hacer administrador</label><br>';


            // Checkbox para bloquear/desbloquear usuario
            echo '<label>';
            echo '<input type="checkbox" name="bloquearCheckbox[]" value="' . $user->IDUSUARIO . '"';
            // Deshabilitar el checkbox si el usuario es administrador
            if ($user->PERFIL == 1) {
                echo ' disabled';
            }
            if ($user->ESTADO == 1) {
                echo 'checked';
            }
           
            echo '> Bloquear/Desbloquear usuario</label><br>';
            // Checkbox para eliminar usuario
            echo '<label>';
            echo '<input type="checkbox" name="eliminarCheckbox[]" value="' . $user->IDUSUARIO . '"';
            if ($user->PERFIL == 1){
                echo ' disabled';
            } 
           
            echo '> Eliminar usuario</label><br>';
            echo '</td>';
            echo '</tr>';
        }
    }
}



// Cuando el usuario realiza cambios, algunos de ellos serán inmodificables, pero otros no, tendrá que reescribir el usuario en función 
// de los campos actualizados
function actualizarUsuario($password, $email, $usernameRoot, $userTypeRoot, $dateRoot, $avatar, &$error) {
    $password = trim($password);
    $email = trim($email);
    $avatar = trim($avatar);
    // Lee todo el contenido del archivo
    $users = file(DATA_DIR . "/usuarios.txt");
    // Abre el archivo para escritura
    $file = fopen(DATA_DIR . "/usuarios.txt", "r+");
    if ($file) {
        foreach ($users as $userLine) {
            // Divide la línea en partes
            list($userTxt, $passSecureTxt, $dateTxt, $emailTxt, $avatarTxt, $userTypeTxt) = explode(";", $userLine);
            // Verifica si es la línea del usuario que se está actualizando
            if ($userTxt == $usernameRoot) {
                // Actualiza la línea con la nueva información
                if ($userTypeRoot == "1") {
                    $actLinea = $usernameRoot . ";" . md5($password) . ";" . $dateRoot . ";" . $email . ";" . $avatar . ";1";
                } else {
                    $actLinea = $usernameRoot . ";" . md5($password) . ";" . $dateRoot . ";" . $email . ";" . $avatar . ";0";
                }
                fprintf($file, $actLinea . PHP_EOL);
                $_SESSION["username"] = $userTxt;
                $_SESSION["password"] = $password;
                $_SESSION["date"] = $dateTxt;
                $_SESSION["email"] = $email;
                $_SESSION["avatar"] = $avatar;
                fclose($file);
                return 1;
            } else {
                // Escribe la línea sin cambios
                fprintf($file, $userLine);
            }
        }
        fclose($file);
        $error = 'NOT_USER';
        return 0;
    } else {
        $error = 'NOT_FILE';
        fclose($file);
        return 0;
    }
}
function validarImagen($imagen, &$error) {
    if (!isset($imagen["name"]) || $imagen["size"] == 0) {  
        $error = 'NOT_FILE';
        return 0; // No se proporcionó ningún archivo
    }
    
    if ($imagen["size"] > 1690000) {
        $error = 'SIZE';
        return 0; // Archivo demasiado grande
    }
    
    $formatosPermitidos = array("image/jpg", "image/jpeg", "image/png", "image/webp");
    
    if (!(in_array($imagen["type"], $formatosPermitidos))) {
        $error = 'FORMAT';
        return 0; // Formato de archivo no permitido
    }

    return $imagen; // Sin errores, tiene el tamaño y formato adecuados
}
function guardarImagen($imagen, $directorio, &$error) {

    // Obtener la ruta donde alojamos el fichero imagen

    $rutaGuardarImagen = $directorio ;

    $rutaGuardarRegistro = $directorio . "images.txt";
    
    $extension = pathinfo($imagen["name"], PATHINFO_EXTENSION);
    
    $nombreFicheroHash = sha1_file($imagen["tmp_name"]);
    
    $nombreFicheroHashExtension = $nombreFicheroHash. ".". $extension;
    
    $rutaCompletaImagen = $rutaGuardarImagen . $nombreFicheroHashExtension;
    
    // Mover la imagen al directorio de destino
    
    $result = move_uploaded_file($imagen["tmp_name"], $rutaCompletaImagen);
    
    if ($result) {
    
    // La imagen se movió correctamente, abrimos fichero
        $file = fopen($rutaGuardarRegistro, 'a');
        if($file){

            $id = date_timestamp_get(date_create());

            $rutaCompletaImagen = str_replace("\\","/",$rutaCompletaImagen);

            fprintf($file,PHP_EOL."%d;%s;%s;%s", $id, $imagen["name"],$nombreFicheroHashExtension,$rutaCompletaImagen);
            
            fclose($file);

            return $nombreFicheroHashExtension;
        }  else {
            $error = 'NOT_FILE';
            return 0; // Error al mover el archivo
            
            }
    } else {
    $error = 'MOVE';
    return 0; // Error al mover el archivo
    
    }  
} 

?>

