<?php
require_once '../../models/connectDB.php'; // Se requiere el archivo 'connectDB.php' para obtener la clase Database.

class Login {
    private $usuario;
    private $contraseña;
    private $db;

    public function __construct(){
        $this->db=Database::connect(); // Se crea una instancia de la clase Database para establecer la conexión a la base de datos.
    }
    
    public function getUsuario(){
        return $this->usuario;
    }
    
    public function setUsuario($usuario){
        $this->usuario=$usuario;
    }
    
    public function getContraseña(){
        return $this->contraseña;
    }
    
    public function setContraseña($contraseña){
        $this->contraseña=$contraseña;
    }

    public function login(){
        $resultado = false;
        $usuario = $this->usuario;
        $contraseña = $this->contraseña;
    
        // Consulta SQL para verificar las credenciales del usuario en la base de datos.
        $sql = "SELECT USUARIO,CONTRASEÑA FROM usuario
        WHERE USUARIO ='$usuario' and contraseña = '$contraseña'";
    
        $login = $this->db->query($sql);
        
        if ($login && $login->num_rows == 1) {
            $usuario = $login->fetch_object();
            $resultado = $usuario;
    
            if ($resultado) {
                $_SESSION['LAST_ACTIVITY'] = time();
                header('location: ../../views/inventario.html'); // Redirige a la página 'inventario.html' si las credenciales son correctas.
            } else {
                echo "<h1 style='text-align:center; color:#222; margin:10px 0px 20px; font-size:25px;'>Usuario o contraseña incorrectos</h1>";
            }
            return $resultado;
        } else {
            echo "<h1 style='text-align: center; color: #303030; margin: 10px 0 20px; font-size: 25px; background-color: #f2f2f2; padding: 10px; border: 1px solid #303030; border-radius: 5px;'>Usuario o contraseña incorrectos</h1>";
            return $resultado;
        }
    }
}

// Crear una instancia de la clase Login.
$log = new Login;
$log->setUsuario($_POST["input_usuario"]); // Establecer el usuario desde los datos enviados mediante POST.
$log->setContraseña($_POST["input_contraseña"]); // Establecer la contraseña desde los datos enviados mediante POST.
$check = $log->login(); // Llamar al método 'login' para verificar las credenciales del usuario.

if ($check && is_object($check)) {
    // Si las credenciales son correctas y se ha iniciado una sesión.
    $_SESSION['identificacion'] = $check;
    if (isset($_SESSION['identificacion'])) {
        $usuario = $_SESSION['identificacion']->USUARIO;
        echo  "Hola Bienvenido: $usuario";
        echo "<br> <br>";
        echo "<a style='text-align:center; color:#303030;  margin: 1rem 1rem 2rem 0rem; font-size:25px;' href='../../views/inventario.html'>Continuar</a>";
    } else {
        echo "No hay sesión iniciada";
    }
} else {
    echo "<br> <br>";
    echo "<a style='display: block; text-align: center; color: #303030; margin: 1rem 0; font-size: 25px; text-decoration: none; background-color: #f2f2f2; padding: 10px 20px; border: 1px solid #303030; border-radius: 5px;' href='../../views/ingresar.html'>Volver a intentar</a>";
}
?>
