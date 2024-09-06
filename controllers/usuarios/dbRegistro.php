<?php
require_once '../../models/connectDB.php'; // Se requiere el archivo 'connectDB.php' para obtener la clase Database.

class Usuario {
    private $nombre;
    private $user;
    private $contraseña;
    private $ccontraseña;
    private $code;
    private $db;

    public function __construct() {
        $this->db = Database::connect(); // Se crea una instancia de la clase Database para establecer la conexión a la base de datos.
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getContraseña() {
        return $this->contraseña;
    }

    public function setContraseña($contraseña) {
        $this->contraseña = $contraseña;
    }

    public function getCContraseña() {
        return $this->ccontraseña;
    }

    public function setCContraseña($ccontraseña) {
        $this->ccontraseña = $ccontraseña;
    }

    public function getCode() {
        return $this->code;
    }

    public function setCode($code) {
        $this->code = $code;
    }

    public function usuarioExiste($username) {
        $sql = "SELECT COUNT(*) as count FROM usuario WHERE usuario = '{$username}'"; // Asegúrate de que 'usuario' sea el nombre correcto de la columna.
        $result = $this->db->query($sql);

        if ($result === false) {
            die('Error en la consulta: ' . $this->db->error); // Mostrar el error de la consulta SQL en caso de problemas.
        }

        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }

    public function save() {
        if ($this->code == '0512') {
            if ($this->contraseña == $this->ccontraseña) {
                // Verificar si el usuario ya existe
                $userExists = $this->usuarioExiste($this->user);

                if (!$userExists) {
                    try {
                        // Consulta SQL para insertar un nuevo usuario en la base de datos.
                        $sql = "INSERT INTO usuario VALUES (
                            '{$this->getNombre()}','{$this->getUser()}',
                            '{$this->getContraseña()}');";
                        $save = $this->db->query($sql);
                        $result = false;

                        if ($save) {
                            $result = true;
                            echo "<h1 style='text-align: center; color: #222; margin: 10px 0 20px; font-size: 25px; background-color: #f2f2f2; padding: 10px; border: 1px solid #222; border-radius: 5px;'>Registro realizado correctamente</h1>";
                            echo "<a style='display: block; text-align: center; color: #222; margin: 1rem auto; font-size: 25px; text-decoration: none; background-color: #f2f2f2; padding: 10px 20px; border: 1px solid #222; border-radius: 5px; width: 200px;' href='../../views/ingresar.html'>Regresar al inicio</a>";
                        }
                    } catch (Exception $ex) {
                        echo "<h1 style='text-align:center; color: #222; margin: 10px 0 20px; font-size: 25px; background-color: #f2f2f2; padding: 10px; border: 1px solid #222; border-radius: 5px;'>Error en el registro</h1>";
                    }
                } else {
                    echo "<h1 style='text-align:center; color: #222; margin: 10px 0 20px; font-size: 25px; background-color: #f2f2f2; padding: 10px; border: 1px solid #222; border-radius: 5px;'>El usuario ya existe, intente con otro o inicie sesión</h1>";
                    echo "<a style='display: block; text-align: center; color: #222; margin: 1rem auto; font-size: 25px; text-decoration: none; background-color: #f2f2f2; padding: 10px 20px; border: 1px solid #222; border-radius: 5px; width: 200px;' href='../../views/registrar.html'>Registrarse</a>";
                    echo "<a style='display: block; text-align: center; color: #222; margin: 1rem auto; font-size: 25px; text-decoration: none; background-color: #f2f2f2; padding: 10px 20px; border: 1px solid #222; border-radius: 5px; width: 200px;' href='../../views/ingresar.html'>Iniciar sesión</a>";
                }
            } else {
                echo "<a style='display: block; text-align: center; color: #222; margin: 1rem auto; font-size: 25px; text-decoration: none; background-color: #f2f2f2; padding: 10px 20px; border: 1px solid #222; border-radius: 5px; width: 200px;' href='../../views/registrar.html'>Las contraseñas son diferentes</a>";
            }
        } else {
            echo "<a style='display: block; text-align: center; color: #222; margin: 1rem auto; font-size: 25px; text-decoration: none; background-color: #f2f2f2; padding: 10px 20px; border: 1px solid #222; border-radius: 5px; width: 200px;' href='../../views/registrar.html'>El código es incorrecto</a>";
        }
    }
}

$usuario = new Usuario;
$usuario->setNombre($_POST["input_nombre"]);
$usuario->setUser($_POST["input_user"]);
$usuario->setContraseña($_POST["input_contraseña"]);
$usuario->setCContraseña($_POST["input_ccontraseña"]);
$usuario->setCode($_POST["input_code"]);
$save = $usuario->save();
?>
