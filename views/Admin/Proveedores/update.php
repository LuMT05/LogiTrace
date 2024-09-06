<?php
// Incluye el archivo "../connect.php" que contiene la lógica de conexión a la base de datos.
include ("../../../models/connect.php");

// Obtiene una conexión a la base de datos llamando a la función "connection()" del archivo "../connect.php".
$con = connection();

// Obtiene el valor del parámetro "nit" de la URL, que se utiliza para identificar el proveedor que se va a editar.
$nit = $_GET['nit'];

// Construye una consulta SQL para seleccionar el proveedor con el NIT correspondiente.
$sql = "SELECT * FROM proveedor WHERE nit ='$nit'";

// Ejecuta la consulta SQL en la conexión a la base de datos y almacena el resultado en la variable $query.
$query = mysqli_query($con, $sql);

// Obtiene los datos del proveedor a editar.
$row = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../assets/styles/barra1.css">
    <link rel="icon" type="image/png" href="../../../assets/img/LOGO1.PNG">
    <link rel="stylesheet" href="../../../assets/styles/Styleproductos1.css">
    <title>Proveedores</title>
</head>
<body>
<div class="form">
    <form action="../../../controllers/Proveedores/editar.php" method="post" accept-charset="utf-8"> <!--El método POST se utiliza para enviar información -->
    <!--Campo oculto para almacenar el NIT del proveedor y poder identificarlo en la actualización. -->
    <input type="hidden" name="NIT" value="<?=$row['nit'] ?>">
    <label>Nit de la empresa</label>
    <!--Campo de entrada para editar el NIT de la empresa, con el valor inicial cargado desde la base de datos. -->
    <input type="text" name="NIT" id="NIT" placeholder="NIT de la empresa" value="<?=$row['nit'] ?>" required>
    <label>Nombre de la empresa</label>
    <!--Campo de entrada para editar el nombre de la empresa, con el valor inicial cargado desde la base de datos. -->
    <input type="text" name="nombre_empresa" id="nombre_empresa" placeholder="Nombre de la empresa" value="<?=$row['empresa'] ?>" required>
    <label>Nombre proveedor</label>
    <!--Campo de entrada para editar el nombre del proveedor, con el valor inicial cargado desde la base de datos. -->
    <input type="text" name="nombre_proveedor" id="nombre_proveedor" placeholder="Nombre del proveedor" value="<?=$row['nombre_contacto'] ?>" required>
    <label>Dirección proveedor</label>
    <!--Campo de entrada para editar la dirección del proveedor, con el valor inicial cargado desde la base de datos. -->
    <input type="text" name="direccion" id="direccion" placeholder="Dirección del proveedor" value="<?=$row['direccion'] ?>" required>
    <label>Teléfono proveedor</label>
    <!--Campo de entrada para editar el teléfono del proveedor, con el valor inicial cargado desde la base de datos. -->
    <input type="number" name="telefono" id="telefono" placeholder="Teléfono del proveedor" value="<?=$row['telefono_contacto'] ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>

    <!--Para enviar la información actualizada del proveedor. -->
    <div class="PROVEEDOR">
        <div class="btnCont">
            <button type="submit" class="btn dark" name="editar">Editar</button>
        </div>
    </div>
</form>
</div>
</body>
</html>
