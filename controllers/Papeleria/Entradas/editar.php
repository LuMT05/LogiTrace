<?php
// Paso 1: Conectar a la base de datos
include("../../../models/connect.php");

// Establecer una conexión a la base de datos
$con = connection();

// Verificar si la conexión fue exitosa
if (!$con) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Obtener datos del formulario
$id = $_POST["id"];
$producto = $_POST["id_productos"];
$proveedor = $_POST["id_proveedor"];
$estado = $_POST["opcion"];
$entrada = $_POST["cant_Salida"];
$tipo_salida = $_POST["id_unidades"];
$fecha = $_POST["fecha"];
$hora = $_POST["hora"];

// Consulta para verificar si el producto existe
$sqlPROVEEDOR = "SELECT * FROM productos WHERE id = $producto";
$ResultadoProducto = mysqli_query($con, $sqlPROVEEDOR);

// Verificar si se encontró un producto con el ID proporcionado
if (mysqli_num_rows($ResultadoProducto) > 0) {
    // Consulta para verificar si el proveedor existe
    $sqlVerificar = "SELECT * FROM proveedor WHERE nit = $proveedor";
    $resultado = mysqli_query($con, $sqlVerificar);

    // Verificar si se encontró un proveedor con el NIT proporcionado
    if (mysqli_num_rows($resultado) > 0) {
        // Consulta para verificar si la unidad de salida existe
        $sqlUnidad = "SELECT * FROM unidades WHERE codigo = $tipo_salida";
        $ResultadoUnidad = mysqli_query($con, $sqlUnidad);

        // Verificar si se encontró una unidad de salida con el código proporcionado
        if (mysqli_num_rows($ResultadoUnidad) > 0) {
            // Consulta para actualizar los datos de entrada
            $sqlUPDATE = "UPDATE entradas SET id_productos='$producto', estado='$estado', cantidad='$entrada',
                cod_unidad='$tipo_salida',fecha_ingreso='$fecha',hora='$hora',Nit_Proveedor='$proveedor' WHERE Id='$id'";
            
            // Ejecutar la consulta de actualización
            if (mysqli_query($con, $sqlUPDATE)) {
                // Mostrar mensaje de éxito y enlace para volver a la página de Entradas
                echo "<h1 style='text-align:center; color:#222; margin:10px 0px 20px; font-size:25px;'>Dato actualizado con éxito.</h1>";
                echo "<a style='display: block; text-align: center; color:#222; margin:1rem auto; font-size:25px; text-decoration:none; background-color:#f2f2f2; padding:10px 20px; border:1px solid #222; border-radius:5px; width:200px;' href='../../../views/Papelera/Entradas.php'>Volver</a>";

                // Actualizar la cantidad en la tabla de productos
                $sqlUpdateCantidad = "UPDATE productos
                    SET cantidad_existentes = (
                        SELECT SUM(cantidad) 
                        FROM entradas 
                        WHERE id_productos = $producto
                    )
                    WHERE id = $producto";

                // Ejecutar la consulta de actualización de cantidad en productos
                if (mysqli_query($con, $sqlUpdateCantidad)) {
                    // Éxito al actualizar la cantidad en productos
                } else {
                    echo "<h1 style='text-align:center; color:#222; margin:10px 0px 20px; font-size:25px;'>Error al actualizar la cantidad en la tabla de productos: " . mysqli_error($con) . "</h1>";
                }
            } else {
                // Mostrar mensaje de error en caso de fallo en la actualización
                echo "<h1 style='text-align:center; color:#222; margin:10px 0px 20px; font-size:25px;'>Error al insertar el dato: " . mysqli_error($con) . "</h1>";
            }
        } else {
            echo "<h1 style='text-align:center; color:#222; margin:10px 0px 20px; font-size:25px;'>La unidad no existe</h1>";
        }
    } else {
        echo "<h1 style='text-align:center; color:#222; margin:10px 0px 20px; font-size:25px;'>El proveedor no existe.</h1>";
    }
} else {
    echo "<h1 style='text-align:center; color:#222; margin:10px 0px 20px; font-size:25px;'>El producto no existe.</h1>";
}

// Paso 3: Cerrar la conexión
mysqli_close($con);
?>
