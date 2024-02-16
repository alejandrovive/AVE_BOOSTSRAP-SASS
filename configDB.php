<?php


// CONSTANTE para acceder al archivo appdata donde estarán almacenados los datos de los usuarios
define('DATA_DIR', __DIR__ . "/../appdata/p1");
define('DATA_FILE', __DIR__ . "/../img/avatar/");
define('DATA_FILE2', __DIR__ . "/../img/productos/");
// Definir constantes relacionadas con la base de datos
define("HOST", "localhost");
define("USER", "root");
define("PASSWORD", "alejandro");
define("DB", "db_tienda_segunda_mano");
define("DRIVER", "mysql");  // Para PDO
define("DSN", DRIVER . ':host=' . HOST . ';dbname=' . DB);
define("OPTIONS", array(PDO::FETCH_BOUND));

$ERRORES = [
    'UNKNOWN' => 'Error desconocido',
    'AUTH_USERNAME' => 'Nombre de usuario incorrecto',
    'INVALID_USERNAME' => 'Nombre de usuario incorrecto',
    'NOT_FILE' => 'Fichero corrupto o inexistente',
    'AUTH_PASSWD' => 'La contraseña debe contener al menos un número, una mayúscula y una minúscula',
    'AUTH_USERNAME_EXISTS' => 'El usuario ya existe',
    'AUTH_BLANKS' => 'Campos vacíos',
    'AUTH_FAILURE' => 'Creedenciales incorrectas',
    'PASS_FAILURE' => 'Las contraseñas no coinciden',
    'PASS_LEN' => 'La longitud de la contraseña es infusiciente',
    'EMAIL_FORMAT' => 'El formato de email no es correcto',
    'EMAIL_LEN' => 'La longitud del email es insuficiente',
    'AGE_FAILURE' => 'Debes ser mayor de edad para poder registrarte',
    'NOT_ARRAY' => 'No hemos podido acceder a los datos',
    'NOT_LINE' => 'No hemos podido acceder a las líneas',
    'NOT_USER' => 'No hemos podido encontrar el usuario',
    // Errores de ficheros
    'NO_FILE' => 'Fichero corrupto o no existe',
    'SIZE' => 'El archivo es demasiado grande',
    'FORMAT' => 'El formato no es el adecuado (jpg, jpeg, png)',
    'MOVE' => 'Error al mover el archivo',
    // Errores de base de datos
    'CONN' => 'Algo falló en la conexión. Por favor, revise su configuración wifi',
    'AUTH' => 'No hemos encontrado ninguna coincidencia. Revise sus datos o creese una nueva cuenta',
    'NOT_NUMBER' => 'El precio debe ser un número entre 1 y 10.000',
    'FILE_NUMBER' => 'No pueden subir más de 5 ficheros',
    'TEXT_INVALID' => 'No se admiten carácteres especiales',
    // Permisos de administrador
    'BLOCK' => 'Su cuenta se encuentra temporalmente bloqueada'
];

$ERROR_FILE = [
    'NO_FILE' => 'Fichero corrupto o no existe',
    'SIZE' => 'El archivo es demasiado grande',
    'FORMAT' => 'El formato no es el adecuado (jpg, jpeg, png)',
    'MOVE' => 'Error al mover el archivo'
];

$ERROR_DB = [
    
]
?>