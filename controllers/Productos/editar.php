<?php
// Incluye el archivo "../connect.php" que contiene la lógica de conexión a la base de datos.
include("../../models/connect.php");

// Obtiene una conexión a la base de datos llamando a la función "connection()" del archivo "../connect.php".
$con = connection();

// Obtiene los nuevos valores del ID del producto y el nombre del producto desde el formulario de edición.
$id = $_POST['id']; // Nuevo valor del ID del producto
$nombre = $_POST['nombre_producto']; // Nuevo nombre del producto

// Construye una consulta SQL para actualizar el campo "material" de la tabla "productos" con el nuevo nombre.
$sql = "UPDATE productos SET material='$nombre' WHERE id='$id'";

// Ejecuta la consulta SQL en la conexión a la base de datos.
$query = mysqli_query($con, $sql);

// Verifica si la consulta se ejecutó con éxito.
if ($query) {
    // Redirige de vuelta a la página de "Productos.php" después de la actualización.
    header("Location: ../../views/Admin/Productos.php");
    exit;
} else {
    // En caso de error, muestra un mensaje de error con la descripción del problema.
    echo "Error al actualizar el producto: " . mysqli_error($con);
}
?>
