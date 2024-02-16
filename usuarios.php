<?php

class Usuarios 
{
	public  $idUsuario;
    public  $username;
    public  $pass;
    public  $nombre;
    public  $apellido1;
    public  $apellido2;
    public  $email;
    public  $avatar;
    public  $fechaNac;
    public  $direccion;
    public  $fechaCreacion;
    public  $fechaModificacion;
    public  $estado;
    public  $perfil;
	
	 public static function parse ($fields) {

		$obj = new Usuarios();
        $obj->idUsuario = $fields['idUsuario'];
        $obj->username = $fields['username'];
        $obj->pass = $fields['pass'];
        $obj->nombre = $fields['nombre'];
        $obj->apellido1 = $fields['apellido1'];
        $obj->apellido2=$fields['apellido2'];
        $obj->email=$fields['email'];
        $obj->direccion = $fields['direccion'];
		$obj->fechaNac = $fields['fechaNac'];
        $obj->fechaCreacion = $fields['fechaCreacion'];
        $obj->fechaModificacion = $fields['fechaModificacion'];
        $obj->estado = $fields['estado'];
        $obj->perfil = $fields['perfil'];
		$obj->avatar = $fields['avatar']; 
		return $obj;
	}
/*
	public function add() {
        $e = isset($_GET["e"]) ? $_GET["e"] : null;
        $this->fechaCreacion = date("Y-m-d H:i:s");
        $this->fechaModificacion = date("Y-m-d H:i:s");
        $this->pass = password_hash($this->pass, PASSWORD_DEFAULT);
        $conn = get_connection();
    
        $SQL = "
            INSERT INTO usuarios (
                username,
                pass,
                email,
                nombre,
                apellido1, 
                apellido2,
                direccion,
                fechaNac,
                fechaCreacion,
                fechaModificacion, 
                estado, 
                perfil,
                avatar
            ) VALUES (
                '".$this->username."',
                '".$this->pass."',
                '".$this->email."',
                '".$this->nombre."',
                '".$this->apellido1."',
                '".$this->apellido2."',
                '".$this->direccion."',
                '".$this->fechaNac."',
                '".$this->fechaCreacion."',
                '".$this->fechaModificacion."',
                '".$this->estado."',
                '".$this->perfil."',
                '".$this->avatar."'
            )";
                
        $result = $conn->query($SQL);
    
        if (!$result) {
            echo "Error en la consulta: " . $conn->error;
            exit;
        }
    }
    */

    public function add() {
        $this->fechaCreacion = date("Y-m-d H:i:s");
        $this->fechaModificacion = date("Y-m-d H:i:s");
        $this->pass = password_hash($this->pass, PASSWORD_DEFAULT);
        $conn = get_connection();
    
        $query = "INSERT INTO usuarios (
                    username,
                    pass,
                    email,
                    nombre,
                    apellido1, 
                    apellido2,
                    direccion,
                    fechaNac,
                    fechaCreacion,
                    fechaModificacion, 
                    estado, 
                    perfil,
                    avatar
                ) VALUES (
                    :username,
                    :pass,
                    :email,
                    :nombre,
                    :apellido1,
                    :apellido2,
                    :direccion,
                    :fechaNac,
                    :fechaCreacion,
                    :fechaModificacion,
                    :estado,
                    :perfil,
                    :avatar
                )";
    
        $fechaCreacion = date("Y-m-d H:i:s");
        $fechaModificacion = date("Y-m-d H:i:s");
    
        $estado = $conn->prepare($query);
        $estado->bindParam(":username", $this->username, PDO::PARAM_STR);
        $estado->bindParam(":pass", $this->pass, PDO::PARAM_STR);
        $estado->bindParam(":email", $this->email, PDO::PARAM_STR);
        $estado->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
        $estado->bindParam(":apellido1", $this->apellido1, PDO::PARAM_STR);
        $estado->bindParam(":apellido2", $this->apellido2, PDO::PARAM_STR);
        $estado->bindParam(":direccion", $this->direccion, PDO::PARAM_STR);
        $estado->bindParam(":fechaNac", $this->fechaNac, PDO::PARAM_STR);
        $estado->bindParam(":fechaCreacion", $fechaCreacion, PDO::PARAM_STR);
        $estado->bindParam(":fechaModificacion", $fechaModificacion, PDO::PARAM_STR);
        $estado->bindParam(":estado", $this->estado, PDO::PARAM_INT);
        $estado->bindParam(":perfil", $this->perfil, PDO::PARAM_INT);
        $estado->bindParam(":avatar", $this->avatar, PDO::PARAM_STR);
    
        if ($estado->execute()) {
            return true;
        } else {
            echo "Error en la consulta: " . $conn->error;
            exit;
        }
    }
    


    public static function getById($conn, $idUsuario) {
        $query = "SELECT * FROM usuarios WHERE idUsuario = :idUsuario";
        $estado = $conn->prepare($query);

        if ($estado === false) {
            die('Error de preparación de la consulta: ' . htmlspecialchars($conn->error));
        }

        $estado->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $estado->execute();
        $user = $estado->fetch(PDO::FETCH_OBJ);
        $estado->closeCursor();


        if ($user !== false) {
            return $user;
        } else {
            return null; 
        }
    }

    public static function updateUserChange($usuario, $conn, $id) {
        var_dump($id);
        
        $query = "UPDATE usuarios SET username = :username, nombre = :nombre, apellido1 = :apellido1, 
            apellido2 = :apellido2, pass = :pass, avatar = :avatar, direccion = :direccion, fechaModificacion = :fechaModificacion WHERE idUsuario = :idUsuario";
        $fechaModificacion = date("Y-m-d H:i:s");
        $estado = $conn->prepare($query);
        $estado->bindParam(":username", $usuario->USERNAME, PDO::PARAM_STR);
        $estado->bindParam(":nombre", $usuario->NOMBRE, PDO::PARAM_STR);
        $estado->bindParam(":apellido1", $usuario->APELLIDO1, PDO::PARAM_STR);
        $estado->bindParam(":apellido2", $usuario->APELLIDO2, PDO::PARAM_STR);
        $estado->bindParam(":pass", $usuario->PASS, PDO::PARAM_STR);
        $estado->bindParam(":avatar", $usuario->AVATAR, PDO::PARAM_STR);
        $estado->bindParam(":direccion", $usuario->DIRECCION, PDO::PARAM_STR);
        $estado->bindParam(":fechaModificacion", $fechaModificacion, PDO::PARAM_STR);
        $estado->bindParam(":idUsuario", $id, PDO::PARAM_INT);

        if ($estado->execute()) {
            return true;
        } else {
            return false;
        }
        
    }
    public static function updateAdmin($conn, $idUsuario){
        $query = "UPDATE usuarios SET perfil = 1 WHERE idUsuario = :userId";
        $estado = $conn->prepare($query);
        $estado->bindParam(":userId", $idUsuario, PDO::PARAM_INT); 
        $estado->execute();
    
        $estado->closeCursor();
    
        if (!$estado) {
            echo "Error en la consulta: " . $conn->error;
            exit;
        }
    }

    public static function userDisabled($conn, $idUsuario){
        $query = "UPDATE usuarios SET estado = 1 WHERE idUsuario = :userId";
        $estado = $conn->prepare($query);
        $estado->bindParam(":userId", $idUsuario, PDO::PARAM_INT);
        $estado->execute();
    
        $estado->closeCursor();
    
        if (!$estado) {
            echo "Error en la consulta: " . $conn->error;
            exit;
        }
    }
    
    public static function userDelete ($conn, $idUsuario) {
        $query= "DELETE FROM usuarios WHERE idUsuario = :idUsuario";
        $estado = $conn->prepare($query);
        $estado->bindParam(":idUsuario",$idUsuario, PDO::PARAM_INT);
        $estado->execute();

        $estado->closeCursor();

        if (!$estado) {
            echo "Error en la consulta: " .$conn->error;
            exit;
        }
    }
    


    public function update6($conn, $idUsuario) {
        $query = "UPDATE usuarios SET ?, ? WHERE idUsuario = ?";
        $this->fechaModificacion = date("Y-m-d H:i:s");
        $estado = $conn->prepare($query);
        $estado->bind_param("i",$idUsuario);
        $estado->execute();

        $result = $estado->get_result();


        if ($result->num_rows > 0) {
            $fieldsUpdate = $result->fetch_assoc();
            return self::parse($fieldsUpdate);
        } else {
            return null;
        }

    }

    public function update1($conn, $idUsuario) {
        $query = "UPDATE usuarios SET username = ?, nombre = ?, apellido1 = ?, 
        apellido2 = ?, pass = ?, avatar = ?, direccion = ?, fechaModificacion = ? WHERE idUsuario = ?";
        $this->fechaModificacion = date("Y-m-d H:i:s");
        $estado = $conn->prepare($query);
        $fields = [$this->username, $this->nombre, $this->apellido1, $this->apellido2, $this->pass, $this->avatar, $this->direccion, $this->fechaModificacion, $idUsuario];
        $estado->execute($fields);
        if ($estado->rowCount() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function update2($conn, $idUsuario){
        try {
            $fechaModificacion = date("Y-m-d H:i:s");
            $pass = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE usuarios SET username = ?, pass = ?, nombre = ?,
            apellido1 = ?, apellido2 = ?, direccion = ?, avatar = ?, fechaModificacion = ? WHERE idUsuario = ?";
            $estado = $conn->prepare($query);
            $estado->bind_param("sssssssssi",$username, $pass, $name, $lastname1, $lastname2, $direccion, $avatar, $fechaModificacion, $idUsuario);
            $estado->execute();

            echo $estado->rowCount()." record UPDATED successfully";
            
        } catch (PDOException $e) {
            echo $query . "<br>" . $e->getMessage();
        }

    }

    public function update3($conn, $idUsuario) {
        $query = "UPDATE usuarios SET username = :username, nombre = :nombre, apellido1 = :apellido1, 
            apellido2 = :apellido2, pass = :pass, avatar = :avatar, direccion = :direccion, fechaModificacion = :fechaModificacion WHERE idUsuario = :idUsuario";
        $this->fechaModificacion = date("Y-m-d H:i:s");
    
        $estado = $conn->prepare($query);
        $estado->bindParam(':username', $this->username, PDO::PARAM_STR);
        $estado->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
        $estado->bindParam(':apellido1', $this->apellido1, PDO::PARAM_STR);
        $estado->bindParam(':apellido2', $this->apellido2, PDO::PARAM_STR);
        $estado->bindParam(':pass', $this->pass, PDO::PARAM_STR);
        $estado->bindParam(':avatar', $this->avatar, PDO::PARAM_STR);
        $estado->bindParam(':direccion', $this->direccion, PDO::PARAM_STR);
        $estado->bindParam(':fechaModificacion', $this->fechaModificacion, PDO::PARAM_STR);
        $estado->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    
        $estado->execute();
    
        if ($estado->rowCount() > 0) {
            return 1; // Actualización exitosa
        } else {
            return 0; // No se realizaron cambios o algo salió mal
        }
    }

    public function update7($conn, $idUsuario) {
        try {
            $fechaModificacion = date("Y-m-d H:i:s");

            $query = "UPDATE usuarios SET username = :username, pass = :pass, nombre = :nombre,
            apellido1 = :apellido1, apellido2 = :apellido2, direccion = :direccion, avatar = :avatar, fechaModificacion = :fechaModificacion WHERE idUsuario = :idUsuario";
    
            $estado = $conn->prepare($query);
    
            $estado->bindParam(':username', $this->username, PDO::PARAM_STR);
            $estado->bindParam(':pass', $this->pass = password_hash($passwordChange, PASSWORD_DEFAULT), PDO::PARAM_STR);
            $estado->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
            $estado->bindParam(':apellido1', $this->apellido1, PDO::PARAM_STR);
            $estado->bindParam(':apellido2', $this->apellido2, PDO::PARAM_STR);
            $estado->bindParam(':direccion', $this->direccion, PDO::PARAM_STR);
            $estado->bindParam(':avatar', $this->avatar, PDO::PARAM_STR);
            $estado->bindParam(':fechaModificacion', $fechaModificacion, PDO::PARAM_STR);
            $estado->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    
            $estado->execute();
    
            echo $estado->rowCount()." record UPDATED successfully";
    
        } catch (PDOException $e) {
            echo $query . "<br>" . $e->getMessage();
        }
    }
    
    

}






 ?>