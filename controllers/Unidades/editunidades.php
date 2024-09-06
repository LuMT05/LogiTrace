<?php
// Incluye el archivo "../connect.php" que contiene la lógica de conexión a la base de datos.
include("../../models/connect.php");

// Obtiene una conexión a la base de datos llamando a la función "connection()" del archivo "../connect.php".
$con = connection();

// Obtiene los nuevos valores del ID de la unidad y el nombre de la unidad desde el formulario de edición.
$id = $_POST['Id_Unidad'];
$nombre = $_POST['nombre_unidad'];

// Construye una consulta SQL para actualizar la descripción de la unidad en la tabla "unidades" con el nuevo nombre.
$sql = "UPDATE unidades SET descripcion='$nombre' WHERE codigo='$id'";

// Ejecuta la consulta SQL en la conexión a la base de datos.
$query = mysqli_query($con, $sql);

// Verifica si la consulta se ejecutó con éxito.
if ($query) {
    // Redirige de vuelta a la página de "Unidades.php" después de la actualización.
    header("Location: ../../views/Admin/Unidades.php");
    exit;
} else {
    // En caso de error, muestra un mensaje de error con la descripción del problema.
    echo "Error al actualizar la unidad: " . mysqli_error($con);
}
?>
