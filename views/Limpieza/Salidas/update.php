<?php
// Paso 1: Incluir el archivo de conexión a la base de datos
include("../../../models/connect.php");

// Establecer la conexión a la base de datos
$con = connection();

// Verificar la conexión
if (!$con) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Paso 2: Obtener el ID de la salida a editar desde la URL
$id = $_GET['id'];

// Crear una consulta SQL para seleccionar los detalles de la salida con el ID proporcionado
$sql = "SELECT * FROM salidas WHERE id = '$id'";

// Ejecutar la consulta
$query = mysqli_query($con, $sql);

// Obtener los datos de la salida desde el resultado de la consulta
$row = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../assets/styles/barra1.css">
    <link rel="icon" type of="image/png" href="../../../assets/img/LOGO1.PNG">
    <link rel="stylesheet" href="../../../assets/styles/Styleproductos1.css">
    <title>Salidas</title>
</head>
<body>
<div class="form">
    <form action="../../../controllers/Limpieza/Salidas/editar.php" method="post" accept-charset="utf-8">
        <!-- Para mostrar el ID de la salida (readonly, no editable) -->
        <label for="id">ID:</label>
        <input type="text" name="id" id="id" placeholder="ID de la salida" value="<?=$row['id'] ?>" readonly>
        
        <!-- Para editar el ID del producto -->
        <label for="opcion">ID producto:</label>
        <input type="text" name="id_productos" id="id_productos" placeholder="ID del producto" value="<?=$row['id_productos'] ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
        
        <!-- Para editar el estado del producto -->
        <label for="opcion">Estado del producto:</label>
        <select name="opcion" id="opcion" value="<?=$row['estado'] ?>">
                <option value="nuevo" <?=($row['estado'] === 'nuevo' ? 'selected' : '')?>>Nuevo</option>
                <option value="usado" <?=($row['estado'] === 'usado' ? 'selected' : '')?>>Usado</option>
                <option value="dañado" <?=($row['estado'] === 'dañado' ? 'selected' : '')?>>Dañado</option>
        </select>
        
        <!-- Para editar la fecha de salida -->
        <label for="fecha">Fecha de salida:</label>
        <input type="date" id="fecha" name="fecha" value="<?=$row['fecha_salida'] ?>">
        
        <!-- Para editar la cantidad a salir -->
        <label>Cantidad a salir</label>
        <input type="number" name="cantidad" id="cantidad" placeholder="Cantidad a salir" value="<?=$row['cantidad'] ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
        
        <!-- Para editar el nombre de la persona que recibe -->
        <label>Nombre de quien recibe</label>
        <input type="text" name="nombre_recibe" id="nombre_recibe" placeholder="Nombre de quien recibe" value="<?=$row['nombre_recibe'] ?>" required>
        
        <!-- Botón para enviar la salida editada -->
        <div class="SALIDA">
            <div class="btnCont"><button type="submit" class="btn dark">Enviar</button> </div>
        </div>
    </form>
</div>
</body>
</html>
