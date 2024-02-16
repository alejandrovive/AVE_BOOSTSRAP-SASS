<?php 
class Productos {
    public $idProducto;
    public $titulo;
    public $descripcion;
    public $precio;
    public $fechaCreacion;
    public $idVendedor;
    public $idComprador;
    public $idCategoria;
    public $idSubcategoria;

    public static function parse ($fields) {

		$obj = new Productos();
        $obj->idProducto = $fields['idProducto'];
        $obj->titulo = $fields['titulo'];
        $obj->descripcion = $fields['descripcion'];
        $obj->precio = $fields['precio'];
        $obj->fechaCreacion = $fields['fechaCreacion'];
        $obj->idVendedor=$fields['idVendedor'];
        $obj->idComprador=$fields['idComprador'];
        $obj->idCategoria = $fields['idCategoria'];
		$obj->idSubcategoria = $fields['idSubcategoria'];
      
		return $obj;
	}

    

    public function add() {
        $e = isset($_GET["e"]) ? $_GET["e"] : null;
        $this->fechaCreacion = date("Y-m-d H:i:s");
        $conn = get_connection();
    
        $SQL = "
            INSERT INTO productos  (
                titulo,
                descripcion,
                precio,
                fechaCreacion, 
                idVendedor,
                idCategoria,
                idSubcategoria
            ) VALUES (
                '".$this->titulo."',
                '".$this->descripcion."',
                '".$this->precio."',
                '".$this->fechaCreacion."',
                '".$this->idVendedor."',
                '".$this->idCategoria."',
                '".$this->idSubcategoria."'
            )";
    
        $result = $conn->query($SQL);
    
        if (!$result) {
            echo "Error en la consulta: " . $conn->error;
            exit;
        }
    }

    public static function getProducts ($conn) {
        $query = "SELECT * FROM productos";
        $estado = $conn->prepare($query);

        if ($estado === false) {
            die('Error de preparación de la consulta: ' . htmlspecialchars($conn->error));
        }


        $estado->execute();
        $products = $estado->fetchAll(PDO::FETCH_OBJ);
        $estado->closeCursor();
        return $products;
    }
    

    /* public static function getPaginacion($conn, $countProductos) {
        $query = "SELECT * FROM productos LIMIT :num ,4";
        $totalPaginas = $countProductos / 4;
        $resto = $totalPaginas % 4;
        $estado = $conn->prepare($query);
        $estado->bindParam(':num', 0, PDO::PARAM_INT);
    }
    */

    //funcion para devolver paginacion de productos
    public static function getPaginacion($conn, $pagina, $registros){
        $productos = [];
        $query = "SELECT * FROM productos LIMIT :pagina , :registros";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":pagina", $pagina, PDO::PARAM_INT);
        $stmt->bindParam(":registros", $registros, PDO::PARAM_INT);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $productos[] = Productos::parse($row);
        }
        return $productos;
    }

    public static function getCategory($conn) {
        $query = "SELECT * FROM categoria";
        $estado = $conn->prepare($query);

        if ($estado === false) {
            die('Error de preparación de la consulta: ' . htmlspecialchars($conn->error));
        }

        $estado->execute();
        $category = $estado->fetchAll(PDO::FETCH_OBJ);
        $estado->closeCursor();


        if ($category !== false) {
            return $category;
        } else {
            return null; 
        }
    }

    public static function getIdProducto($conn) {
        $query = "SELECT idProducto FROM productos ORDER BY idProducto DESC LIMIT 1";
        $estado = $conn->prepare($query);

        if ($estado === false) {
            die('Error de preparación de la consulta: ' . htmlspecialchars($conn->error));
        }

        $estado->execute();
        $idProducto = $estado->fetch(PDO::FETCH_OBJ);
        $estado->closeCursor();


        if ($idProducto !== false) {
            return $idProducto;
        } else {
            return null; 
        }
    }

    public static function getSubcategoriasPorCategoria($conn, $categoriaId) {
        $query = "SELECT subcategoria.* FROM subcategoria
              INNER JOIN categoria ON subcategoria.idCategoria = categoria.idCategoria
              WHERE categoria.idCategoria = :categoriaId";
    
        $estado = $conn->prepare($query);
    
        if ($estado === false) {
            die('Error de preparación de la consulta: ' . htmlspecialchars($conn->error));
        }
    
        // Bind del parámetro :categoriaId
        $estado->bindParam(':categoriaId', $categoriaId, PDO::PARAM_INT);
    
        $estado->execute();
        $subcategory = $estado->fetchAll(PDO::FETCH_OBJ);
        $estado->closeCursor();
    
        if ($subcategory !== false) {
            return $subcategory;
        } else {
            return null;
        }
    }

    public static function getAllImagenesProducto($conn, $idProducto) {
        $idProducto = intval($idProducto);
        $query = "SELECT imagen FROM fotosproductos 
        INNER JOIN productos on  fotosproductos.idProducto = productos.idProducto 
        WHERE fotosproductos.idProducto = :idProducto";

        $estado=$conn->prepare($query);

        if ($estado === false) {
            die('Error de preparación de la consulta: ' . htmlspecialchars($conn->error));
        }
        $estado->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);

        $estado->execute();

        $fotosProducto = $estado->fetchAll(PDO::FETCH_OBJ);
        $estado->closeCursor();
        if ($fotosProducto !== false) {
            return $fotosProducto;
        } else {
            return null;
        }
    
    }
    
}

?>