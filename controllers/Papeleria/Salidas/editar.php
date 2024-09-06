<?php
include("../../../models/connect.php"); // Incluye el archivo de conexión a la base de datos

$con = connection(); // Establece la conexión a la base de datos

if (!$con) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error()); // Muestra un mensaje de error si no se puede conectar
}

$id = $_POST["id"]; // Obtiene el valor del campo "id" desde el formulario
$producto = $_POST["id_productos"]; // Obtiene el valor del campo "id_productos" desde el formulario
$estado = $_POST["opcion"]; // Obtiene el valor del campo "opcion" (estado) desde el formulario
$fecha = $_POST["fecha"]; // Obtiene el valor del campo "fecha" desde el formulario
$salida = $_POST["cantidad"]; // Obtiene el valor del campo "cantidad" desde el formulario
$nombre_recibe = $_POST["nombre_recibe"]; // Obtiene el valor del campo "nombre_recibe" desde el formulario

// Verificar si el producto existe
$sqlProducto = "SELECT * FROM productos WHERE id = ?";
$stmtProducto = mysqli_prepare($con, $sqlProducto);
mysqli_stmt_bind_param($stmtProducto, "i", $producto);
mysqli_stmt_execute($stmtProducto);
$resultadoProducto = mysqli_stmt_get_result($stmtProducto);

if (mysqli_num_rows($resultadoProducto) > 0) {
    // Obtener la cantidad existente y la cantidad total de salidas del producto
    $row = mysqli_fetch_assoc($resultadoProducto);
    $cantidadExistente = $row["cantidad_existentes"];

    // Calcular la cantidad total de salidas para el producto
    $sqlTotalSalidas = "SELECT SUM(cantidad) AS total_salidas FROM salidas WHERE id_productos = ?";
    $stmtTotalSalidas = mysqli_prepare($con, $sqlTotalSalidas);
    mysqli_stmt_bind_param($stmtTotalSalidas, "i", $producto);
    mysqli_stmt_execute($stmtTotalSalidas);
    $resultadoTotalSalidas = mysqli_stmt_get_result($stmtTotalSalidas);
    $rowTotalSalidas = mysqli_fetch_assoc($resultadoTotalSalidas);
    $totalSalidas = $rowTotalSalidas["total_salidas"];

    // Calcular la cantidad disponible
    $cantidadDisponible = $cantidadExistente - $totalSalidas;

    // Verificar si es posible actualizar la cantidad existente en la tabla de productos
    $nuevaCantidad = $cantidadExistente + $totalSalidas;
    $Cantidadinsertar = $nuevaCantidad - $salida;

    if ($Cantidadinsertar >= 0) {
        // Continuar con la inserción o actualización de salida

        // Verificar si el ID existe en la tabla de salidas
        $sqlVerificarSALIDA = "SELECT * FROM salidas WHERE id = ?";
        $stmtVerificarSALIDA = mysqli_prepare($con, $sqlVerificarSALIDA);
        mysqli_stmt_bind_param($stmtVerificarSALIDA, "i", $id);
        mysqli_stmt_execute($stmtVerificarSALIDA);
        $resultadoVerificarSALIDA = mysqli_stmt_get_result($stmtVerificarSALIDA);

        if (mysqli_num_rows($resultadoVerificarSALIDA) > 0) {
            // Actualizar la salida
            $sqlActualizar = "UPDATE salidas SET id_productos=?, estado=?, fecha_salida=?, cantidad=?, nombre_recibe=? WHERE id=?";
            $stmtActualizar = mysqli_prepare($con, $sqlActualizar);
            mysqli_stmt_bind_param($stmtActualizar, "issisi", $producto, $estado, $fecha, $salida, $nombre_recibe, $id);

            if (mysqli_stmt_execute($stmtActualizar)) {
                // Actualizar la cantidad existente
                $sqlActualizarCantidad = "UPDATE productos SET cantidad_existentes = ? WHERE id = ?";
                $stmtActualizarCantidad = mysqli_prepare($con, $sqlActualizarCantidad);
                mysqli_stmt_bind_param($stmtActualizarCantidad, "ii", $Cantidadinsertar, $producto);

                if (mysqli_stmt_execute($stmtActualizarCantidad)) {
                    mostrarMensajeExito("Dato actualizado con éxito");
                } else {
                    mostrarMensajeError("Error al actualizar la cantidad existente: " . mysqli_error($con));
                }
            } else {
                mostrarMensajeError("Error al actualizar el dato: " . mysqli_error($con));
            }
        } else {
            // Insertar nueva salida
            $sqlInsertar = "INSERT INTO salidas (id, id_productos, estado, fecha_salida, cantidad, nombre_recibe) VALUES (?, ?, ?, ?, ?, ?)";
            $stmtInsertar = mysqli_prepare($con, $sqlInsertar);
            mysqli_stmt_bind_param($stmtInsertar, "iissis", $id, $producto, $estado, $fecha, $salida, $nombre_recibe);

            if (mysqli_stmt_execute($stmtInsertar)) {
                // Actualizar la cantidad existente
                $sqlActualizarCantidad = "UPDATE productos SET cantidad_existentes = ? WHERE id = ?";
                $stmtActualizarCantidad = mysqli_prepare($con, $sqlActualizarCantidad);
                mysqli_stmt_bind_param($stmtActualizarCantidad, "ii", $Cantidadinsertar, $producto);

                if (mysqli_stmt_execute($stmtActualizarCantidad)) {
                    mostrarMensajeExito("Dato insertado con éxito");
                } else {
                    mostrarMensajeError("Error al insertar el dato: " . mysqli_error($con));
                }
            } else {
                mostrarMensajeError("Error al insertar el dato: " . mysqli_error($con));
            }
        }
    } else {
        mostrarMensajeError("No es posible actualizar esta cantidad, ya que la cantidad máxima que le puedes agregar es de $cantidadExistente para un total de productos de $nuevaCantidad");
    }
} else {
    mostrarMensajeError("El producto no existe");
}

// Función para mostrar mensaje de éxito
function mostrarMensajeExito($mensaje) {
    echo "<h1 style='text-align:center; color: #222; margin: 10px 0 20px; font-size: 25px; background-color: #f2f2f2; padding: 10px; border: 1px solid #222; border-radius: 5px;'>$mensaje</h1>";
    echo "<a style='display: block; text-align: center; color: #222; margin: 1rem auto; font-size: 25px; text-decoration: none; background-color: #f2f2f2; padding: 10px 20px; border: 1px solid #222; border-radius: 5px; width: 200px;' href='../../../views/Papelera/Salidas.php'>Ingresa otro producto</a>";
}

// Función para mostrar mensaje de error
function mostrarMensajeError($mensaje) {
    echo "<h1 style='text-align:center; color: #222; margin: 10px 0 20px; font-size: 25px; background-color: #f2f2f2; padding: 10px; border: 1px solid #222; border-radius: 5px;'>$mensaje</h1>";
    echo "<a style='display: block; text-align: center; color: #222; margin: 1rem auto; font-size: 25px; text-decoration: none; background-color: #f2f2f2; padding: 10px 20px; border: 1px solid #222; border-radius: 5px; width: 200px;' href='../../../views/Papelera/Salidas.php'>Vuelve a intentar</a>";
}

mysqli_close($con); // Cierra la conexión a la base de datos
?>
