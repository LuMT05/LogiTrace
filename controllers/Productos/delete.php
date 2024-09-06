<?php
// Incluye el archivo "../connect.php" que contiene la lógica de conexión a la base de datos.
include ("../../models/connect.php");

// Obtiene una conexión a la base de datos llamando a la función "connection()" del archivo "../connect.php".
$con = connection();

// Obtiene el valor del parámetro "id" de la URL, que se utiliza para identificar el producto que se va a eliminar.
$id = $_GET['id'];

// Construye una consulta SQL para eliminar el producto de la tabla "productos" con el ID correspondiente.
$sql = "DELETE FROM productos WHERE id ='$id'";

// Ejecuta la consulta SQL en la conexión a la base de datos.
$query = mysqli_query($con, $sql);

// Verifica si la consulta se ejecutó con éxito.
if ($query) {
    // Redirige de vuelta a la página de "Productos.php" después de la eliminación.
    header("Location: ../../views/Admin/Productos.php");
    exit;
} else {
    // En caso de error, muestra un mensaje de error con la descripción del problema.
    echo "Error al eliminar el producto: " . mysqli_error($con);
}
?>
