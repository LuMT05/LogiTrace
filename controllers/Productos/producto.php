<?php
// Requiere el archivo "connectDB.php" que probablemente contiene la lógica de conexión a la base de datos.
require_once "../../models/connectDB.php";

// Define la clase "Unidades".
class Unidades {
    private $id;
    private $nombre_producto;
    private $db;

    // Constructor de la clase.
    public function __construct() {
        // Se conecta a la base de datos al crear una instancia de la clase.
        $this->db = Database::connect();
    }

    // Métodos getter y setter para obtener y establecer el ID del producto.
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    // Métodos getter y setter para obtener y establecer el nombre del producto.
    public function getNombre_Producto() {
        return $this->nombre_producto;
    }

    public function setNombre_Producto($nombre_producto) {
        $this->nombre_producto = $nombre_producto;
    }

    // Método para guardar un nuevo producto en la base de datos.
    public function save() {
        // Verifica si el producto ya existe en la base de datos.
        $message = $this->checkIfProductExists($this->getId());

        if ($message === "success") {
            try {
                // Construye una consulta SQL para insertar un nuevo producto en la base de datos.
                $sql = "INSERT INTO productos VALUES (
                    '{$this->getId()}','{$this->getNombre_Producto()}','','');";

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

    // Función para verificar si un producto ya existe en la base de datos.
    private function checkIfProductExists($productId) {
        $sql = "SELECT * FROM productos WHERE id = '{$productId}'";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            return "El código ya existe";
        }
        return "success";
    }
}

// Crea una instancia de la clase "Unidades".
$unidades = new Unidades;
$unidades->setId($_POST["id"]);
$unidades->setNombre_Producto($_POST["nombre_producto"]);
$unidades->save();

// Función para mostrar un mensaje con un botón para regresar.
function mostrarMensaje($mensaje) {
    echo "<h1 style='text-align:center; color:#222; margin:10px 0px 20px; font-size:25px;'>$mensaje</h1>";
    echo "<a style='display: block; text-align: center; color: #222; margin: 1rem auto; font-size: 25px; text-decoration: none; background-color: #f2f2f2; padding: 10px 20px; border: 1px solid #222; border-radius: 5px; width: 200px;' href='../../views/Admin/Productos.php'>Regresar</a>";
}
?>
