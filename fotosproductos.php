<?php

class fotosProductos {
    public $idProducto;
    public $imagen;
   
    public static function parse ($fields) {

		$obj = new fotosProductos();
        $obj->idProducto = $fields['idProducto'];
        $obj->imagen = $fields['imagen'];

		return $obj;
	}


public function add() {
    $e = isset($_GET["e"]) ? $_GET["e"] : null;
    $conn = get_connection();

    $SQL = "
    INSERT INTO fotosproductos  (
        imagen,
        idProducto
    ) VALUES (
        :imagen,
        :idProducto
    )";

$stmt = $conn->prepare($SQL);

// Vincular los valores usando enlaces de parámetros
$stmt->bindParam(':imagen', $this->imagen, PDO::PARAM_LOB);
$stmt->bindParam(':idProducto', $this->idProducto, PDO::PARAM_INT);

// Ejecutar la consulta preparada
$result = $stmt->execute();

if (!$result) {
    echo "Error en la consulta: " . $stmt->errorInfo()[2];  // Obtener el mensaje de error detallado
    exit;
}
}

}
?>



