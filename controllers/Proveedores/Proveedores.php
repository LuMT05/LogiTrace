<?php
// Requiere el archivo "connectDB.php" que probablemente contiene la lógica de conexión a la base de datos.
require_once "../../models/connectDB.php";

// Define la clase "Proveedores".
class Proveedores {
    private $NIT;
    private $nombre_empresa;
    private $nombre_proveedor;
    private $direccion;
    private $telefono;
    private $db;

    // Constructor de la clase.
    public function __construct() {
        // Se conecta a la base de datos al crear una instancia de la clase.
        $this->db = Database::connect();
    }

    // Métodos getter y setter para obtener y establecer el NIT del proveedor.
    public function getNIT() {
        return $this->NIT;
    }

    public function setNIT($NIT) {
        $this->NIT = $NIT;
    }

    // Métodos getter y setter para obtener y establecer el nombre de la empresa.
    public function getNombreEmpresa() {
        return $this->nombre_empresa;
    }

    public function setNombreEmpresa($nombre_empresa) {
        $this->nombre_empresa = $nombre_empresa;
    }

    // Métodos getter y setter para obtener y establecer el nombre del proveedor.
    public function getNombreProveedor() {
        return $this->nombre_proveedor;
    }

    public function setNombreProveedor($nombre_proveedor) {
        $this->nombre_proveedor = $nombre_proveedor;
    }

    // Métodos getter y setter para obtener y establecer la dirección del proveedor.
    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    // Métodos getter y setter para obtener y establecer el teléfono del proveedor.
    public function getTelefono() {
        return $this->telefono;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    // Método para guardar un nuevo proveedor en la base de datos.
    public function save() {
        // Verifica si el proveedor ya existe en la base de datos.
        $message = $this->checkIfProviderExists($this->getNIT());

        if ($message === "success") {
            try {
                // Construye una consulta SQL para insertar un nuevo proveedor en la base de datos.
                $sql = "INSERT INTO proveedor VALUES (
                    '{$this->getNIT()}','{$this->getNombreEmpresa()}','{$this->getNombreProveedor()}',
                    '{$this->getDireccion()}','{$this->getTelefono()}');";

                // Ejecuta la consulta SQL.
                $save = $this->db->query($sql);

                if ($save) {
                    $message = "Registro realizado correctamente";
                }
            } catch (Exception $ex) {
                $message = "Error al realizar el registro";
            }
        }

        // Llama a la función "mostrarMensaje" para mostrar un mensaje en la página.
        mostrarMensaje($message);
    }

    // Función para verificar si un proveedor ya existe en la base de datos.
    private function checkIfProviderExists($providerNIT) {
        $sql = "SELECT * FROM proveedor WHERE NIT = '{$providerNIT}'";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            return "El NIT ya existe";
        }
        return "success";
    }
}

// Crea una instancia de la clase "Proveedores".
$proveedores = new Proveedores;
$proveedores->setNIT($_POST["NIT"]);
$proveedores->setNombreEmpresa($_POST["nombre_empresa"]);
$proveedores->setNombreProveedor($_POST["nombre_proveedor"]);
$proveedores->setDireccion($_POST["direccion"]);
$proveedores->setTelefono($_POST["telefono"]);
$proveedores->save();

// Función para mostrar un mensaje con un botón para regresar.
function mostrarMensaje($mensaje) {
    echo "<h1 style='text-align:center; color:#222; margin:10px 0px 20px; font-size:25px;'>$mensaje</h1>";
    echo "<a style='display: block; text-align: center; color: #222; margin: 1rem auto; font-size: 25px; text-decoration: none; background-color: #f2f2f2; padding: 10px 20px; border: 1px solid #222; border-radius: 5px; width: 200px;' href='../../views/Admin/Proveedores.php'>Regresar</a>";
}
?>
