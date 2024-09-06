<?php
// Paso 1: Conectar a la base de datos
include("../../../models/connect.php");

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

// Paso 2: Consultar si el producto existe
$sqlPROVEEDOR = "SELECT * FROM productos WHERE id = $producto";
$ResultadoProducto = mysqli_query($con, $sqlPROVEEDOR);

if (mysqli_num_rows($ResultadoProducto) > 0) {

    // Paso 3: Verificar si el proveedor existe
    $sqlVerificar = "SELECT * FROM proveedor WHERE nit = $proveedor";
    $resultado = mysqli_query($con, $sqlVerificar);

    if (mysqli_num_rows($resultado) > 0) {

        // Paso 4: Verificar si la unidad existe
        $sqlUnidad = "SELECT * FROM unidades WHERE codigo = $tipo_salida";
        $ResultadoUnidad = mysqli_query($con, $sqlUnidad);

        if (mysqli_num_rows($ResultadoUnidad) > 0) {

            // Paso 5: Actualizar la entrada
            $sqlUPDATE = "UPDATE entradas SET id_productos='$producto', estado='$estado', cantidad='$entrada',
            cod_unidad='$tipo_salida',fecha_ingreso='$fecha',hora='$hora',Nit_Proveedor='$proveedor' WHERE Id='$id'";
            
            if (mysqli_query($con, $sqlUPDATE)) {
                mostrarMensajeExito("Dato actualizado con éxito.");
                header("Location ../Entradas.php");

                // Paso 6: Actualizar la cantidad en la tabla de productos
                $sqlUpdateCantidad = "UPDATE productos
                SET cantidad_existentes = (
                    SELECT SUM(cantidad) 
                    FROM entradas 
                    WHERE id_productos = $producto
                    )
                    WHERE id = $producto";
                
                if (mysqli_query($con, $sqlUpdateCantidad)) {
                    // La cantidad se actualizó con éxito en la tabla de productos
                } else {
                    mostrarMensajeError("Error al actualizar la cantidad en la tabla de productos: " . mysqli_error($con));
                }
            } else {
                mostrarMensajeError("Error al actualizar el dato: " . mysqli_error($con));
            }
        } else {
            mostrarMensajeError("La unidad no existe");
        }
    } else {
        mostrarMensajeError("El proveedor no existe.");
    }
} else {
    mostrarMensajeError("El producto no existe.");
}

// Función para mostrar mensaje de éxito
function mostrarMensajeExito($mensaje) {
    echo "<h1 style='text-align:center; color: #222; margin: 10px 0 20px; font-size: 25px; background-color: #f2f2f2; padding: 10px; border: 1px solid #222; border-radius: 5px;'>$mensaje</h1>";
    echo "<a style='display: block; text-align: center; color: #222; margin: 1rem auto; font-size: 25px; text-decoration: none; background-color: #f2f2f2; padding: 10px 20px; border: 1px solid #222; border-radius: 5px; width: 200px;' href='../../../views/Limpieza/Entradas.php'>Volver a Entradas</a>";
}

// Función para mostrar mensaje de error
function mostrarMensajeError($mensaje) {
    echo "<h1 style='text-align:center; color: #222; margin: 10px 0 20px; font-size: 25px; background-color: #f2f2f2; padding: 10px; border: 1px solid #222; border-radius: 5px;'>$mensaje</h1>";
    echo "<a style='display: block; text-align: center; color: #222; margin: 1rem auto; font-size: 25px; text-decoration: none; background-color: #f2f2f2; padding: 10px 20px; border: 1px solid #222; border-radius: 5px; width: 200px;' href='../../../views/Limpieza/Entradas.php'>Volver a Entradas</a>";
}

// Paso 3: Cerrar la conexión
mysqli_close($con);
?>
