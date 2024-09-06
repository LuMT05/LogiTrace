<?php
include("../../../models/connect.php"); // Incluye el archivo de conexión a la base de datos

$con = connection(); // Establece la conexión a la base de datos

if (!$con) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error()); // Muestra un mensaje de error si no se puede conectar
}

$id = $_POST["id"]; // Obtiene el valor del campo "id" desde el formulario
$producto = $_POST["id_productos"]; // Obtiene el valor del campo "id_productos" desde el formulario
$proveedor = $_POST["id_proveedor"]; // Obtiene el valor del campo "id_proveedor" desde el formulario
$estado = $_POST["opcion"]; // Obtiene el valor del campo "opcion" (estado) desde el formulario
$entrada = $_POST["cant_Salida"]; // Obtiene el valor del campo "cant_Salida" (cantidad de entrada) desde el formulario
$tipo_salida = $_POST["id_unidades"]; // Obtiene el valor del campo "id_unidades" desde el formulario
$fecha = $_POST["fecha"]; // Obtiene el valor del campo "fecha" desde el formulario
$hora = $_POST["hora"]; // Obtiene el valor del campo "hora" desde el formulario

// Consulta para verificar la existencia del producto en la tabla "productos"
$sqlProducto = "SELECT * FROM productos WHERE id = ?";
$stmtProducto = mysqli_prepare($con, $sqlProducto);
mysqli_stmt_bind_param($stmtProducto, "i", $producto);
mysqli_stmt_execute($stmtProducto);
$resultadoProducto = mysqli_stmt_get_result($stmtProducto);

if (mysqli_num_rows($resultadoProducto) > 0) {
    // Consulta para verificar la existencia del proveedor en la tabla "proveedor"
    $sqlProveedor = "SELECT * FROM proveedor WHERE nit = ?";
    $stmtProveedor = mysqli_prepare($con, $sqlProveedor);
    mysqli_stmt_bind_param($stmtProveedor, "s", $proveedor);
    mysqli_stmt_execute($stmtProveedor);
    $resultadoProveedor = mysqli_stmt_get_result($stmtProveedor);

    if (mysqli_num_rows($resultadoProveedor) > 0) {
        // Consulta para verificar la existencia de la unidad en la tabla "unidades"
        $sqlUnidad = "SELECT * FROM unidades WHERE codigo = ?";
        $stmtUnidad = mysqli_prepare($con, $sqlUnidad);
        mysqli_stmt_bind_param($stmtUnidad, "s", $tipo_salida);
        mysqli_stmt_execute($stmtUnidad);
        $resultadoUnidad = mysqli_stmt_get_result($stmtUnidad);

        if (mysqli_num_rows($resultadoUnidad) > 0) {
            // Consulta para verificar la existencia de la entrada en la tabla "entradas"
            $sqlVerificarEntrada = "SELECT * FROM entradas WHERE Id = ?";
            $stmtVerificarEntrada = mysqli_prepare($con, $sqlVerificarEntrada);
            mysqli_stmt_bind_param($stmtVerificarEntrada, "i", $id);
            mysqli_stmt_execute($stmtVerificarEntrada);
            $resultadoVerificarEntrada = mysqli_stmt_get_result($stmtVerificarEntrada);

            if (mysqli_num_rows($resultadoVerificarEntrada) == 0) {
                // Consulta para insertar los datos en la tabla "entradas"
                $sqlInsertar = "INSERT INTO entradas (id, id_productos, estado, cantidad, cod_unidad, fecha_ingreso, hora, Nit_Proveedor) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmtInsertar = mysqli_prepare($con, $sqlInsertar);
                mysqli_stmt_bind_param($stmtInsertar, "iisidsss", $id, $producto, $estado, $entrada, $tipo_salida, $fecha, $hora, $proveedor);
                
                if (mysqli_stmt_execute($stmtInsertar)) {
                    mostrarMensajeExito("Dato insertado con éxito");
                    
                    // Consulta para actualizar la cantidad existente en la tabla "productos"
                    $sqlActualizarCantidad = "UPDATE productos SET cantidad_existentes = cantidad_existentes + ?, tipo = 'Componente' WHERE id = ?";
                    $stmtActualizarCantidad = mysqli_prepare($con, $sqlActualizarCantidad);
                    mysqli_stmt_bind_param($stmtActualizarCantidad, "ii", $entrada, $producto);
                    
                    if (mysqli_stmt_execute($stmtActualizarCantidad)) {
                        // Éxito al actualizar la cantidad existente
                    } else {
                        mostrarMensajeError("Error al actualizar la cantidad existente: " . mysqli_error($con));
                    }
                } else {
                    mostrarMensajeError("Error al insertar el dato: " . mysqli_error($con));
                }
            } else {
                mostrarMensajeError("El id de la entrada ya existe");
            }
        } else {
            mostrarMensajeError("La unidad no existe");
        }
    } else {
        mostrarMensajeError("El proveedor no existe");
    }
} else {
    mostrarMensajeError("El producto no existe");
}

mysqli_close($con); // Cierra la conexión a la base de datos

function mostrarMensajeExito($mensaje) {
    echo "<h1 style='text-align:center; color: #222; margin: 10px 0 20px; font-size: 25px; background-color: #f2f2f2; padding: 10px; border: 1px solid #222; border-radius: 5px;'>$mensaje</h1>";
    echo "<a style='display: block; text-align: center; color: #222; margin: 1rem auto; font-size: 25px; text-decoration: none; background-color: #f2f2f2; padding: 10px 20px; border: 1px solid #222; border-radius: 5px; width: 200px;' href='../../../views/Papelera/Entradas.php'>Ingresa otro producto</a>";
}

function mostrarMensajeError($mensaje) {
    echo "<h1 style='text-align:center; color: #222; margin: 10px 0 20px; font-size: 25px; background-color: #f2f2f2; padding: 10px; border: 1px solid #222; border-radius: 5px;'>$mensaje</h1>";
    echo "<a style='display: block; text-align: center; color: #222; margin: 1rem auto; font-size: 25px; text-decoration: none; background-color: #f2f2f2; padding: 10px 20px; border: 1px solid #222; border-radius: 5px; width: 200px;' href='../../../views/Papelera/Entradas.php'>Vuelve a intentar</a>";
}
?>
