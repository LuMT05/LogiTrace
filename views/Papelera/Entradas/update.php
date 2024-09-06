<?php
include ("../../../models/connect.php");

// Conectar a la base de datos
$con = connection();

// Obtener el ID de la entrada a editar desde la URL
$id = $_GET['Id'];

// Consultar la entrada en la base de datos
$sql = "SELECT * FROM entradas WHERE Id = '$id'";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">
<head lang="es" xml:lang="es">
    <head lang="es" xml:lang="es">
        <link rel="stylesheet" type="text/css" href="../../../assets/styles/barra1.css">
        <link rel="icon" type="image/png" href="../../../assets/img/LOGO1.PNG">
        <link rel="stylesheet" href="../../../assets/styles/Stylegeneral1.css">
        <link rel="stylesheet" href="../../../assets/styles/STYLETABLA1.css">
        <title>Editar</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    </head>
<body>
    
<div>
    <div class="form">
        <form action="../../../controllers/Papeleria/Entradas/editar.php" method="post" accept-charset="utf-8">
            <!-- Muestra un formulario para editar los campos de la entrada -->
            <label for="opcion">ID:</label>
            <input type="text" name="id" id="id" placeholder="ID de la entrada" value="<?=$row['Id'] ?>" readonly>

            <!-- Para tomar el valor del ID del producto -->
            <label for="opcion">ID producto:</label>
            <input type="text" name="id_productos" id="id_productos" placeholder="ID del producto ingresado" value="<?=$row['id_productos'] ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>

            <!-- Para tomar el valor del ID del proveedor -->
            <label for="opcion">ID proveedor:</label>
            <input type="text" name ="id_proveedor" id="id_proveedor" placeholder="ID del proveedor" value="<?=$row['Nit_Proveedor'] ?>" required>

            <!-- Para tomar el valor del estado del producto -->
            <label for="opcion">Estado del producto:</label>
            <select name="opcion" id="opcion">
                <option value="nuevo" <?=($row['estado'] === 'nuevo' ? 'selected' : '')?>>Nuevo</option>
                <option value="usado" <?=($row['estado'] === 'usado' ? 'selected' : '')?>>Usado</option>
                <option value="dañado" <?=($row['estado'] === 'dañado' ? 'selected' : '')?>>Dañado</option>
            </select>

            <!-- Para tomar el valor de la cantidad de entrada -->
            <label>Cantidad entrada</label>
            <input type="number" name="cant_Salida" id="cant_Salida" placeholder="cantidad de entrada" value="<?=$row['cantidad'] ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>

            <!-- Para tomar el valor de la ID de la unidad de salida -->
            <label>ID unidad de salida</label>
            <input type="number" name="id_unidades" id="id_unidades" placeholder="ID de la unidad de salida" value="<?=$row['cod_unidad'] ?>" required>

            <!-- Para tomar el valor de la fecha de ingreso -->
            <label for="fecha">Fecha ingreso:</label>
            <input type="date" id="fecha" name="fecha" value="<?=$row['fecha_ingreso'] ?>">

            <!-- Para tomar el valor de la hora de ingreso -->
            <label for="hora">Hora ingreso(00:00/24:00):</label>
            <input type="time" id="hora" name="hora" value="<?=$row['hora'] ?>">

            <!-- Botón para enviar la edición de la entrada -->
            <div class="ENTRADA">
                <div class="btnCont">
                    <button type="submit" class="btn dark">Editar</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
