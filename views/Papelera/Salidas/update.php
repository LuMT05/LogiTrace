<?php
include ("../../../models/connect.php");  // Incluye el archivo de conexión a la base de datos.
$con = connection();  // Establece una conexión a la base de datos y almacena el objeto de conexión en $con.

$id = $_GET['id'];  // Obtiene el valor del parámetro 'id' de la URL, que se utilizará para recuperar los datos de la salida.
$sql = "SELECT * FROM salidas WHERE id = '$id'";  // Crea una consulta SQL para seleccionar los datos de la salida con el ID especificado.

$query = mysqli_query($con, $sql);  // Ejecuta la consulta SQL en la base de datos y almacena el resultado en $query.
$row = mysqli_fetch_array($query);  // Obtiene la fila de resultados como un array asociativo y almacena los datos de la salida en $row.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../assets/styles/barra1.css">  <!-- Enlaza una hoja de estilos CSS para la barra de navegación. -->
    <link rel="icon" type="image/png" href="../../../assets/img/LOGO1.PNG">  <!-- Define un icono para la pestaña del navegador. -->
    <link rel="stylesheet" href="../../../assets/styles/Styleproductos1.css">  <!-- Enlaza una hoja de estilos CSS para la página. -->
    <title>Salidas</title>  <!-- Establece el título de la página en la pestaña del navegador. -->
</head>
<body>
<div class="form">  <!-- Crea un contenedor con la clase "form" para el formulario. -->
    <form action="../../../controllers/Papeleria/Salidas/editar.php" method="post" accept-charset="utf-8">
        <!-- Para tomar el valor del ID de la salida -->
        <label for="id">ID:</label>
        <input type="text" name="id" id="id" placeholder="ID de la salida" value="<?=$row['id'] ?>" readonly>
        <!-- Para tomar el valor del ID del producto -->
        <label for="opcion">ID producto:</label>
        <input type="text" name="id_productos" id="id_productos" placeholder="ID del producto" value="<?=$row['id_productos'] ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
        <!-- Para tomar el valor del estado del producto -->
        <label for="opcion">Estado del producto:</label>
        <select name="opcion" id="opcion">
            <option value="nuevo" <?=($row['estado'] === 'nuevo') ? 'selected' : ''?>>Nuevo</option>
            <option value="usado" <?=($row['estado'] === 'usado') ? 'selected' : ''?>>Usado</option>
            <option value="dañado" <?=($row['estado'] === 'dañado') ? 'selected' : ''?>>Dañado</option>
        </select>
        <!-- Para tomar el valor de la fecha de salida -->
        <label for="fecha">Fecha de salida:</label>
        <input type="date" id="fecha" name="fecha" value="<?=$row['fecha_salida'] ?>">
        <!-- Para tomar el valor de la cantidad a salir -->
        <label>Cantidad a salir</label>
        <input type="number" name="cantidad" id="cantidad" placeholder="Cantidad a salir" value="<?=$row['cantidad'] ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
        <!-- Para tomar el nombre de la persona que recibe -->
        <label>Nombre de quien recibe</label>
        <input type="text" name="nombre_recibe" id="nombre_recibe" placeholder="Nombre de quien recibe" value="<?=$row['nombre_recibe'] ?>" required>
        <!-- Para enviar la salida -->
        <div class="SALIDA">
            <div class="btnCont"><button type="submit" class="btn dark">Enviar</button></div>
        </div>
    </form>
</div>
</body>
</html>
