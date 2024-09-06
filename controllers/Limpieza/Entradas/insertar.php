<?php
// Incluye el archivo de conexión a la base de datos
include("../../../models/connect.php");

// Establece la conexión a la base de datos
$con = connection();

// Verifica si se pudo conectar a la base de datos
if (!$con) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Obtiene los datos del formulario
$id = $_POST["id"];
$producto = $_POST["id_productos"];
$proveedor = $_POST["id_proveedor"];
$estado = $_POST["opcion"];
$entrada = $_POST["cant_Salida"];
$tipo_salida = $_POST["id_unidades"];
$fecha = $_POST["fecha"];
$hora = $_POST["hora"];

// Verificar si el producto existe en la base de datos
$sqlProducto = "SELECT * FROM productos WHERE id = ?";
$stmtProducto = mysqli_prepare($con, $sqlProducto);
mysqli_stmt_bind_param($stmtProducto, "i", $producto);
mysqli_stmt_execute($stmtProducto);
$resultadoProducto = mysqli_stmt_get_result($stmtProducto);

if (mysqli_num_rows($resultadoProducto) > 0) {
    // Verificar si el proveedor existe en la base de datos
    $sqlProveedor = "SELECT * FROM proveedor WHERE nit = ?";
    $stmtProveedor = mysqli_prepare($con, $sqlProveedor);
    mysqli_stmt_bind_param($stmtProveedor, "s", $proveedor);
    mysqli_stmt_execute($stmtProveedor);
    $resultadoProveedor = mysqli_stmt_get_result($stmtProveedor);

    if (mysqli_num_rows($resultadoProveedor) > 0) {
        // Verificar si la unidad existe en la base de datos
        $sqlUnidad = "SELECT * FROM unidades WHERE codigo = ?";
        $stmtUnidad = mysqli_prepare($con, $sqlUnidad);
        mysqli_stmt_bind_param($stmtUnidad, "s", $tipo_salida);
        mysqli_stmt_execute($stmtUnidad);
        $resultadoUnidad = mysqli_stmt_get_result($stmtUnidad);

        if (mysqli_num_rows($resultadoUnidad) > 0) {
            // Verificar si el ID de entrada ya existe en la base de datos
            $sqlVerificarEntrada = "SELECT * FROM entradas WHERE Id = ?";
            $stmtVerificarEntrada = mysqli_prepare($con, $sqlVerificarEntrada);
            mysqli_stmt_bind_param($stmtVerificarEntrada, "i", $id);
            mysqli_stmt_execute($stmtVerificarEntrada);
            $resultadoVerificarEntrada = mysqli_stmt_get_result($stmtVerificarEntrada);

            if (mysqli_num_rows($resultadoVerificarEntrada) == 0) {
                // Insertar entrada en la base de datos
                $sqlInsertar = "INSERT INTO entradas (Id, id_productos, estado, cantidad, cod_unidad, fecha_ingreso, hora, Nit_Proveedor) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmtInsertar = mysqli_prepare($con, $sqlInsertar);
                mysqli_stmt_bind_param($stmtInsertar, "iisiisss", $id, $producto, $estado, $entrada, $tipo_salida, $fecha, $hora, $proveedor);
                
                if (mysqli_stmt_execute($stmtInsertar)) {
                    mostrarMensajeExito("Dato insertado con éxito");
                } else {
                    mostrarMensajeError("Error al insertar el dato: " . mysqli_error($con));
                }
                
                // Actualizar la cantidad existente del producto en la base de datos
                $sqlCantidad = "SELECT * FROM productos WHERE id = ?";
                $stmtCantidad = mysqli_prepare($con, $sqlCantidad);
                mysqli_stmt_bind_param($stmtCantidad, "i", $producto);
                mysqli_stmt_execute($stmtCantidad);
                $resultadoCantidad = mysqli_stmt_get_result($stmtCantidad);
                
                if (mysqli_num_rows($resultadoCantidad) > 0) {
                    $row = mysqli_fetch_assoc($resultadoCantidad);
                    $cantidadExistente = $row["cantidad_existentes"];
                    $nuevaCantidad = $cantidadExistente + $entrada;
                    
                    $sqlActualizarCantidad = "UPDATE productos SET cantidad_existentes = ?, tipo = 'Artefactos' WHERE id = ?";
                    $stmtActualizarCantidad = mysqli_prepare($con, $sqlActualizarCantidad);
                    mysqli_stmt_bind_param($stmtActualizarCantidad, "ii", $nuevaCantidad, $producto);
                    
                    if (mysqli_stmt_execute($stmtActualizarCantidad)) {
                        // Éxito al actualizar la cantidad existente
                    } else {
                        mostrarMensajeError("Error al actualizar la cantidad existente: " . mysqli_error($con));
                    }
                }
            } else {
                mostrarMensajeError("El ID de la entrada ya existe");
            }
        } else {
            mostrarMensajeError("La unidad no existe en la base de datos");
        }
    } else {
        mostrarMensajeError("El proveedor no existe en la base de datos");
    }
} else {
    mostrarMensajeError("El producto no existe en la base de datos");
}

// Función para mostrar mensaje de éxito
function mostrarMensajeExito($mensaje) {
    echo "<h1 style='text-align:center; color: #222; margin: 10px 0 20px; font-size: 25px; background-color: #f2f2f2; padding: 10px; border: 1px solid #222; border-radius: 5px;'>$mensaje</h1>";
    echo "<a style='display: block; text-align: center; color: #222; margin: 1rem auto; font-size: 25px; text-decoration: none; background-color: #f2f2f2; padding: 10px 20px; border: 1px solid #222; border-radius: 5px; width: 200px;' href='../../../views/Limpieza/Entradas.php'>Ingresa otro producto</a>";
}

// Función para mostrar mensaje de error
function mostrarMensajeError($mensaje) {
    echo "<h1 style='text-align:center; color: #222; margin: 10px 0 20px; font-size: 25px; background-color: #f2f2f2; padding: 10px; border: 1px solid #222; border-radius: 5px;'>$mensaje</h1>";
    echo "<a style='display: block; text-align: center; color: #222; margin: 1rem auto; font-size: 25px; text-decoration: none; background-color: #f2f2f2; padding: 10px 20px; border: 1px solid #222; border-radius: 5px; width: 200px;' href='../../../views/Limpieza/Entradas.php'>Vuelve a intentar</a>";
}

// Cierra la conexión a la base de datos
mysqli_close($con);
?>
