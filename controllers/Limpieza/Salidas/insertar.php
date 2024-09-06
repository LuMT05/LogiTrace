<<?php
// Incluye el archivo de conexión a la base de datos
include("../../../models/connect.php");

// Establece la conexión a la base de datos
$con = connection();

// Verifica si la conexión se realizó con éxito
if (!$con) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Obtiene datos del formulario HTML usando $_POST
$id = $_POST["id"];
$producto = $_POST["id_productos"];
$estado = $_POST["opcion"];
$fecha = $_POST["fecha"];
$salida = $_POST["cantidad"];
$nombre_recibe = $_POST["nombre_recibe"];

// Verificar si el producto existe en la base de datos
$sqlProducto = "SELECT * FROM productos WHERE id = ?";
$stmtProducto = mysqli_prepare($con, $sqlProducto);
mysqli_stmt_bind_param($stmtProducto, "i", $producto);
mysqli_stmt_execute($stmtProducto);
$resultadoProducto = mysqli_stmt_get_result($stmtProducto);

if (mysqli_num_rows($resultadoProducto) > 0) {
    // El producto existe, obtenemos la cantidad existente
    $row = mysqli_fetch_assoc($resultadoProducto);
    $cantidadExistente = $row["cantidad_existentes"];

    // Verificar si la cantidad de salida es menor o igual a la cantidad existente
    if ($salida <= $cantidadExistente) {
        // Continúa con la inserción de la salida

        // Verifica si el ID de salida ya existe en la tabla "salidas"
        $sqlVerificarSALIDA = "SELECT * FROM salidas WHERE id = ?";
        $stmtVerificarSALIDA = mysqli_prepare($con, $sqlVerificarSALIDA);
        mysqli_stmt_bind_param($stmtVerificarSALIDA, "i", $id);
        mysqli_stmt_execute($stmtVerificarSALIDA);
        $resultadoVerificarSALIDA = mysqli_stmt_get_result($stmtVerificarSALIDA);

        if (mysqli_num_rows($resultadoVerificarSALIDA) == 0) {
            // El ID de salida no existe, procedemos a insertar la salida
            $sqlInsertar = "INSERT INTO salidas (id, id_productos, estado, fecha_salida, cantidad, nombre_recibe) VALUES (?, ?, ?, ?, ?, ?)";
            $stmtInsertar = mysqli_prepare($con, $sqlInsertar);
            mysqli_stmt_bind_param($stmtInsertar, "iissis", $id, $producto, $estado, $fecha, $salida, $nombre_recibe);

            if (mysqli_stmt_execute($stmtInsertar)) {
                // La inserción fue exitosa, mostramos mensaje de éxito

                mostrarMensajeExito("Dato insertado con éxito");

                // Actualizar la cantidad existente del producto
                $nuevaCantidad = $cantidadExistente - $salida;
                $sqlActualizarCantidad = "UPDATE productos SET cantidad_existentes = ? WHERE id = ?";
                $stmtActualizarCantidad = mysqli_prepare($con, $sqlActualizarCantidad);
                mysqli_stmt_bind_param($stmtActualizarCantidad, "ii", $nuevaCantidad, $producto);

                if (mysqli_stmt_execute($stmtActualizarCantidad)) {
                    // Éxito al actualizar la cantidad existente del producto
                } else {
                    mostrarMensajeError("Error al actualizar la cantidad existente: " . mysqli_error($con));
                }
            } else {
                mostrarMensajeError("Error al insertar el dato: " . mysqli_error($con));
            }
        } else {
            mostrarMensajeError("El ID de la salida ya existe");
        }
    } else {
        mostrarMensajeError("La cantidad no está disponible. La cantidad existente es: $cantidadExistente");
    }
} else {
    mostrarMensajeError("El producto no existe");
}

// Función para mostrar mensaje de éxito
function mostrarMensajeExito($mensaje) {
    echo "<h1 style='text-align:center; color: #222; margin: 10px 0 20px; font-size: 25px; background-color: #f2f2f2; padding: 10px; border: 1px solid #222; border-radius: 5px;'>$mensaje</h1>";
    echo "<a style='display: block; text-align: center; color: #222; margin: 1rem auto; font-size: 25px; text-decoration: none; background-color: #f2f2f2; padding: 10px 20px; border: 1px solid #222; border-radius: 5px; width: 200px;' href='../../../views/Limpieza/Salidas.php'>Ingresa otro producto</a>";
}

// Función para mostrar mensaje de error
function mostrarMensajeError($mensaje) {
    echo "<h1 style='text-align:center; color: #222; margin: 10px 0 20px; font-size: 25px; background-color: #f2f2f2; padding: 10px; border: 1px solid #222; border-radius: 5px;'>$mensaje</h1>";
    echo "<a style='display: block; text-align: center; color: #222; margin: 1rem auto; font-size: 25px; text-decoration: none; background-color: #f2f2f2; padding: 10px 20px; border: 1px solid #222; border-radius: 5px; width: 200px;' href='../../../views/Limpieza/Salidas.php'>Vuelve a intentar</a>";
}

// Cierra la conexión a la base de datos
mysqli_close($con);
?>
