<?php
// Incluye el archivo "../connect.php" que contiene la lógica de conexión a la base de datos.
include("../../../models/connect.php");

// Obtiene una conexión a la base de datos llamando a la función "connection()" del archivo "../connect.php".
$con = connection();

// Obtiene el valor del parámetro "id" de la URL, que se utiliza para identificar el producto que se va a editar.
$id = $_GET['id'];

// Construye una consulta SQL para seleccionar el producto con el ID correspondiente.
$sql = "SELECT * FROM productos WHERE id = '$id'";

// Ejecuta la consulta SQL en la conexión a la base de datos y almacena el resultado en la variable $query.
$query = mysqli_query($con, $sql);

// Obtiene los datos del producto a editar.
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
    <title>Productos</title>
</head>
<body>
<div class="form">
        <form action="../../../controllers/Productos/editar.php" 
        method="post" accept-charset="utf-8"> <!--El método POST se utiliza para enviar información -->
    
    <!--Campo de entrada para editar el ID del producto, con el valor inicial cargado desde la base de datos. -->
    <label>ID del producto</label>
    <input type="text" name="id" id="id" placeholder="ID del producto" value="<?=$row['id'] ?>" readonly>
    
    <!--Campo de entrada para editar el nombre del producto, con el valor inicial cargado desde la base de datos. -->
    <label>Nombre del producto</label>
    <input type="text" name="nombre_producto" id="nombre_producto" placeholder="Nombre del producto" value="<?=$row['material'] ?>">

    <!--Para enviar la información actualizada del producto. -->
    <div class="PRODUCTOS">
        <div class="btnCont">
            <button type="submit" class="btn dark" name="editar">Editar</button>
        </div>
    </div>
</form>
</div>
</body>
</html>
