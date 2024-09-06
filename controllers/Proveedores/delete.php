<?php
// Incluye el archivo "../connect.php" que contiene la lógica de conexión a la base de datos.
include ("../../models/connect.php");

// Obtiene una conexión a la base de datos llamando a la función "connection()" del archivo "../connect.php".
$con = connection();

// Obtiene el valor del parámetro "nit" de la URL, que se utiliza para identificar el proveedor que se va a eliminar.
$nit = $_GET['nit'];

// Construye una consulta SQL para eliminar el proveedor de la tabla "proveedor" con el NIT correspondiente.
$sql = "DELETE FROM proveedor WHERE nit ='$nit'";

// Ejecuta la consulta SQL en la conexión a la base de datos.
$query = mysqli_query($con, $sql);

// Verifica si la consulta se ejecutó con éxito.
if ($query) {
    // Redirige de vuelta a la página de "Proveedores.php" después de la eliminación.
    header("Location: ../../views/Admin/Proveedores.php");
    exit;
} else {
    // En caso de error, muestra un mensaje de error con la descripción del problema.
    echo "Error al eliminar el proveedor: " . mysqli_error($con);
}
?>
