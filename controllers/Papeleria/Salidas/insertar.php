<?php
// Incluye el archivo que contiene la función de conexión a la base de datos
include("../../../models/connect.php");

// Establece una conexión a la base de datos
$con = connection();

// Verifica si la conexión a la base de datos fue exitosa
if (!$con) {
    // Muestra un mensaje de error y termina el script si la conexión falla
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Obtiene los datos enviados mediante el método POST
$id = $_POST["id"];                  // ID de la salida
$producto = $_POST["id_productos"];   // ID del producto
$estado = $_POST["opcion"];           // Estado de la salida
$fecha = $_POST["fecha"];             // Fecha de la salida
$salida = $_POST["cantidad"];         // Cantidad de productos en la salida
$nombre_recibe = $_POST["nombre_recibe"]; // Nombre de la persona que recibe la salida

// Verifica si el producto existe en la base de datos
$sqlProducto = "SELECT * FROM productos WHERE id = ?";
$stmtProducto = mysqli_prepare($con, $sqlProducto);
mysqli_stmt_bind_param($stmtProducto, "i", $producto);
mysqli_stmt_execute($stmtProducto);
$resultadoProducto = mysqli_stmt_get_result($stmtProducto);

if (mysqli_num_rows($resultadoProducto) > 0) {
    // Obtiene la cantidad existente del producto
    $row = mysqli_fetch_assoc($resultadoProducto);
    $cantidadExistente = $row["cantidad_existentes"];

    // Verifica si la cantidad de salida es menor o igual a la cantidad existente
    if ($salida <= $cantidadExistente) {
        // Continúa con la inserción de la salida

        // Verifica si el ID de la salida ya existe en la base de datos
        $sqlVerificarSALIDA = "SELECT * FROM salidas WHERE id = ?";
        $stmtVerificarSALIDA = mysqli_prepare($con, $sqlVerificarSALIDA);
        mysqli_stmt_bind_param($stmtVerificarSALIDA, "i", $id);
        mysqli_stmt_execute($stmtVerificarSALIDA);
        $resultadoVerificarSALIDA = mysqli_stmt_get_result($stmtVerificarSALIDA);

        if (mysqli_num_rows($resultadoVerificarSALIDA) == 0) {
            // Inserta una nueva salida en la base de datos
            $sqlInsertar = "INSERT INTO salidas (id, id_productos, estado, fecha_salida, cantidad, nombre_recibe) VALUES (?, ?, ?, ?, ?, ?)";
            $stmtInsertar = mysqli_prepare($con, $sqlInsertar);
            mysqli_stmt_bind_param($stmtInsertar, "iissis", $id, $producto, $estado, $fecha, $salida, $nombre_recibe);

            if (mysqli_stmt_execute($stmtInsertar)) {
                // Muestra un mensaje de éxito

                echo "<h1 style='text-align:center; color: #222; margin: 10px 0 20px; font-size: 25px; background-color: #f2f2f2; padding: 10px; border: 1px solid #222; border-radius: 5px;'>Dato insertado con éxito</h1>";
                echo "<a style='display: block; text-align: center; color: #222; margin: 1rem auto; font-size: 25px; text-decoration: none; background-color: #f2f2f2; padding: 10px 20px; border: 1px solid #222; border-radius: 5px; width: 200px;' href='../../../views/Papelera/Salidas.php'>Ingresa otro producto</a>";

                // Actualiza la cantidad existente del producto en la base de datos
                $nuevaCantidad = $cantidadExistente - $salida;
                $sqlActualizarCantidad = "UPDATE productos SET cantidad_existentes = ? WHERE id = ?";
                $stmtActualizarCantidad = mysqli_prepare($con, $sqlActualizarCantidad);
                mysqli_stmt_bind_param($stmtActualizarCantidad, "ii", $nuevaCantidad, $producto);

                if (mysqli_stmt_execute($stmtActualizarCantidad)) {
                    // Éxito al actualizar la cantidad existente
                } else {
                    // Muestra un mensaje de error si falla la actualización
                    echo "<h1 style='text-align:center; color: #222; margin: 10px 0 20px; font-size: 25px; background-color: #f2f2f2; padding: 10px; border: 1px solid #222; border-radius: 5px;'>Error al actualizar la cantidad existente: " . mysqli_error($con) . "</h1>";
                }
            } else {
                // Muestra un mensaje de error si falla la inserción de la salida
                echo "<h1 style='text-align:center; color: #222; margin: 10px 0 20px; font-size: 25px; background-color: #f2f2f2; padding: 10px; border: 1px solid #222; border-radius: 5px;'>Error al insertar el dato: " . mysqli_error($con) . "</h1>";
            }
        } else {
            // Muestra un mensaje de error si el ID de la salida ya existe
            echo "<h1 style='text-align:center; color: #222; margin: 10px 0 20px; font-size: 25px; background-color: #f2f2f2; padding: 10px; border: 1px solid #222; border-radius: 5px;'>El ID de la salida ya existe</h1>";
        }
    } else {
        // Muestra un mensaje de error si la cantidad no está disponible
        echo "<h1 style='text-align:center; color: #222; margin: 10px 0 20px; font-size: 25px; background-color: #f2f2f2; padding: 10px; border: 1px solid #222; border-radius: 5px;'>La cantidad no está disponible. La cantidad existente es: $cantidadExistente</h1>";
    }
} else {
    // Muestra un mensaje de error si el producto no existe
    echo "<h1 style='text-align:center; color: #222; margin: 10px 0 20px; font-size: 25px; background-color: #f2f2f2; padding: 10px; border: 1px solid #222; border-radius: 5px;'>El producto no existe</h1>";
}

// Cierra la conexión a la base de datos
mysqli_close($con);
?>
