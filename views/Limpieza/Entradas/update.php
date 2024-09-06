<?php
// Incluye el archivo de conexión a la base de datos.
include ("../../../models/connect.php");
$con = connection();

// Obtiene el ID de la entrada a editar desde la URL.
$id = $_GET['Id'];

// Construye la consulta SQL para seleccionar la entrada con el ID proporcionado.
$sql = "SELECT * FROM entradas WHERE Id = '$id'";

$query = mysqli_query($con, $sql);

// Obtiene los datos de la entrada seleccionada.
$row = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
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
        <form action="../../../controllers/Limpieza/Entradas/editar.php" method="post" accept-charset="utf-8">
            
            <!-- Campos de entrada para editar los detalles de la entrada -->
            <label for="opcion">ID:</label>
            <input type="text" name="id" id="id" placeholder="ID de la entrada" value="<?=$row['Id'] ?>" readonly>
            
            <label for="opcion">ID producto:</label>
            <input type="text" name="id_productos" id="id_productos" placeholder="ID del producto ingresado" value="<?=$row['id_productos'] ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
            
            <label for="opcion">ID proveedor:</label>
            <input type="text" name="id_proveedor" id="id_proveedor" placeholder="ID del proveedor" value="<?=$row['Nit_Proveedor'] ?>" required>
            
            <label for="opcion">Estado del producto:</label>
            <select name="opcion" id="opcion">
                <!-- Selecciona la opción previamente almacenada -->
                <option value="nuevo" <?php if ($row['estado'] === 'nuevo') echo 'selected'; ?>>Nuevo</option>
                <option value="usado" <?php if ($row['estado'] === 'usado') echo 'selected'; ?>>Usado</option>
                <option value="dañado" <?php if ($row['estado'] === 'dañado') echo 'selected'; ?>>Dañado</option>
            </select>
            
            <label>Cantidad entrada</label>
            <input type="number" name="cant_Salida" id="cant_Salida" placeholder="Cantidad de entrada" value="<?=$row['cantidad'] ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
            
            <label>ID unidad de salida</label>
            <input type="number" name="id_unidades" id="id_unidades" placeholder="ID de la unidad de salida" value="<?=$row['cod_unidad'] ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
            
            <label for="fecha">Fecha ingreso:</label>
            <input type="date" id="fecha" name="fecha" value="<?=$row['fecha_ingreso'] ?>">
            
            <label for="hora">Hora ingreso(00:00/24:00):</label>
            <input type="time" id="hora" name="hora" value="<?=$row['hora'] ?>">
            
            <!-- Botón para editar la entrada -->
            <div class="ENTRADA">
                <div class="btnCont">
                    <button type="submit" class="btn dark">Editar</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
