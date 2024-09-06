<?php
// Incluye el archivo "../connect.php" que contiene la lógica de conexión a la base de datos.
include ("../../models/connect.php");

// Obtiene una conexión a la base de datos llamando a la función "connection()" del archivo "../connect.php".
$con = connection();

// Obtiene el valor del parámetro "codigo" de la URL, que se utiliza para identificar la unidad que se va a eliminar.
$id = $_GET['codigo'];

// Construye una consulta SQL para eliminar la unidad de la tabla "unidades" con el código correspondiente.
$sql = "DELETE FROM unidades WHERE codigo ='$id'";

// Ejecuta la consulta SQL en la conexión a la base de datos.
$query = mysqli_query($con, $sql);

// Verifica si la consulta se ejecutó con éxito.
if ($query) {
    // Redirige de vuelta a la página de "Unidades.php" después de la eliminación.
    header("Location: ../../views/Admin/Unidades.php");
    exit;
} else {
    // En caso de error, muestra un mensaje de error con la descripción del problema.
    echo "Error al eliminar la unidad: " . mysqli_error($con);
}
?>

