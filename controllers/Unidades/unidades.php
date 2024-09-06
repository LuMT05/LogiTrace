<?php
// Requiere el archivo "connectDB.php" que probablemente contiene la lógica de conexión a la base de datos.
require_once "../../models/connectDB.php";

// Define la clase "Unidades".
class Unidades {
    private $id_unidad;
    private $nombre_unidad;
    private $db;

    // Constructor de la clase.
    public function __construct() {
        // Se conecta a la base de datos al crear una instancia de la clase.
        $this->db = Database::connect();
    }

    // Métodos getter y setter para obtener y establecer el ID de la unidad.
    public function getId_unidad() {
        return $this->id_unidad;
    }

    public function setId_unidad($id_unidad) {
        $this->id_unidad = $id_unidad;
    }

    // Métodos getter y setter para obtener y establecer el nombre de la unidad.
    public function getNombreunidad() {
        return $this->nombre_unidad;
    }

    public function setNombreunidad($nombre_unidad) {
        $this->nombre_unidad = $nombre_unidad;
    }

    // Método para guardar una nueva unidad en la base de datos.
    public function save() {
        try {
            // Construye una consulta SQL para insertar una nueva unidad en la base de datos.
            $sql = "INSERT INTO unidades VALUES (
                '{$this->getId_unidad()}','{$this->getNombreunidad()}');";
            
            // Ejecuta la consulta SQL.
            $save = $this->db->query($sql);
            $result = false;

            if ($save) {
                $result = true;
                // Muestra un mensaje en la página si el registro se realiza correctamente.
                echo "<h1 style='text-align:center; color:#222; margin:10px 0px 20px; font-size:25px;'>Registro realizado correctamente</h1>";
                echo "<a style='display: block; text-align: center; color:#222; margin:1rem auto; font-size:25px; text-decoration:none; background-color:#f2f2f2; padding:10px 20px; border:1px solid #222; border-radius:5px; width:200px;' href='../../views/Admin/Unidades.php'>Volver</a>";
            }
            return $result;
        } catch (Exception $ex) {
            // Muestra un mensaje en la página si el código de unidad ya existe.
            echo "<h1 style='text-align:center; color:#222; margin:10px 0px 20px; font-size:25px;'>El código ya existe</h1>";
            echo "<a style='display: block; text-align: center; color:#222; margin:1rem auto; font-size:25px; text-decoration:none; background-color:#f2f2f2; padding:10px 20px; border:1px solid #222; border-radius:5px; width:200px;' href='../../views/Admin/Unidades.php'>Volver</a>";
        }
    }
}

// Crea una instancia de la clase "Unidades".
$unidades = new Unidades;
$unidades->setId_unidad($_POST["Id_Unidad"]);
$unidades->setNombreunidad($_POST["nombre_unidad"]);
$save = $unidades->save();
?>
