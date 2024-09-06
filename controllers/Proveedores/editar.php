<?php
// Incluye el archivo "../connect.php" que contiene la lógica de conexión a la base de datos.
include("../../models/connect.php");

// Obtiene una conexión a la base de datos llamando a la función "connection()" del archivo "../connect.php".
$con = connection();

// Obtiene los nuevos valores del NIT del proveedor, nombre de la empresa, nombre de contacto, dirección y teléfono desde el formulario de edición.
$nit = $_POST['NIT'];
$empresa = $_POST['nombre_empresa'];
$nombre_contacto = $_POST['nombre_proveedor'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];

// Construye una consulta SQL para actualizar los campos de la tabla "proveedor" con los nuevos valores.
$sql = "UPDATE proveedor SET empresa='$empresa', nombre_contacto='$nombre_contacto', direccion='$direccion', telefono_contacto='$telefono' WHERE nit='$nit'";

// Ejecuta la consulta SQL en la conexión a la base de datos.
$query = mysqli_query($con, $sql);

// Verifica si la consulta se ejecutó con éxito.
if ($query) {
    // Redirige de vuelta a la página de "Proveedores.php" después de la actualización.
    header("Location: ../../views/Admin/Proveedores.php");
    exit;
} else {
    // En caso de error, muestra un mensaje de error con la descripción del problema.
    echo "Error al actualizar el proveedor: " . mysqli_error($con);
}
?>
