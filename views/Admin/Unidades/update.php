<?php
// Incluye el archivo "../connect.php" que contiene la lógica de conexión a la base de datos.
include ("../../../models/connect.php");

// Obtiene una conexión a la base de datos llamando a la función "connection()" del archivo "../connect.php".
$con = connection();

// Obtiene el valor del parámetro "codigo" de la URL, que se utiliza para identificar la unidad que se va a editar.
$id = $_GET['codigo'];

// Realiza una consulta SQL para seleccionar la unidad con el código correspondiente.
$sql = "SELECT * FROM unidades WHERE codigo ='$id'";

// Ejecuta la consulta SQL en la conexión a la base de datos y almacena el resultado en la variable $query.
$query = mysqli_query($con, $sql);

// Obtiene los datos de la unidad a editar.
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
    <link rel="stylesheet" href="../../../assets/styles/STYLETABLA1.css">
    <title>Editar</title>
</head>
<body>
<div class="form">
        <form action="../../../controllers/Unidades/editunidades.php" method="post" accept-charset="utf-8">
        <!-- Un campo oculto que almacena el código de la unidad para identificarla en la actualización. -->
        <input type="hidden" name="codigo" value="<?=$row['codigo'] ?>">
        <label>Identificador de la unidad</label>
        <!-- Campo de entrada para editar el ID de la unidad, con el valor inicial cargado desde la base de datos. -->
        <input type="number" name="Id_Unidad" id="Id_Unidad" placeholder="Identificador de unidad" value="<?=$row['codigo'] ?>" readonly>
        <label>Descripcion</label>
        <!-- Campo de entrada para editar el nombre de la unidad, con el valor inicial cargado desde la base de datos. -->
        <input type="text" name="nombre_unidad" id="nombre_unidad" placeholder="Ingrese la unidad" value="<?=$row['descripcion'] ?>" required>

        <!-- Para enviar la información actualizada de la unidad. -->
        <div class="UNIDAD">
            <div class="btnCont">
                <button type="submit" class="btn dark" name="editar">Editar</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
