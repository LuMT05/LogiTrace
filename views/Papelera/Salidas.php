<?php
// Incluye el archivo de conexión a la base de datos
include("../../models/connect.php");

// Realiza la conexión a la base de datos utilizando la función connection() definida en el archivo "connect.php"
$con = connection();

// Query SQL para seleccionar datos de salidas y realizar un JOIN con la tabla de productos
$sql = "SELECT salidas.*, productos.* FROM salidas INNER JOIN productos ON salidas.id_productos = productos.id";

// Ejecuta la consulta SQL y almacena el resultado en la variable $query
$query = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../../assets/styles/barra1.css">
    <link rel="icon" type="image/png" href="../../assets/img/LOGO1.PNG">
    <link rel="stylesheet" href="../../assets/styles/STYLETABLA1.css">
    <link rel="stylesheet" href="../../assets/styles/Stylegeneral1.css">
    <title>Salidas</title>
</head>
<body>
    <header class="header">
        <div class="container">
            <a href=""><img src="../../assets/img/escudo1.png" type="image/png"></a>
            <h1 class="titulo">Componentes</h1>
        </div>
    </header>
    
    <div class="form">
        <form action="../../controllers/Papeleria/Salidas/insertar.php" method="post" accept-charset="utf-8">
            <!-- Formulario para agregar una salida -->
            <label for="id">ID:</label>
            <input type="text" name="id" id="id" placeholder="ID de la salida" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
            
            <label for="id_productos">ID producto:</label>
            <input type="text" name="id_productos" id="id_productos" placeholder="ID del producto" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
            
            <label for="opcion">Estado del producto:</label>
            <select name="opcion" id="opcion">
                <option value="nuevo">Nuevo</option>
                <option value="usado">Usado</option>
                <option value="dañado">Dañado</option>
            </select>
            
            <label for="fecha">Fecha de entrega:</label>
            <input type="date" id="fecha" name="fecha">
            
            <label for="cantidad">Cantidad a entregar:</label>
            <input type="number" name="cantidad" id="cantidad" placeholder="Cantidad a salir" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
            
            <label for="nombre_recibe">Nombre de quien recibe:</label>
            <input type="text" name="nombre_recibe" id="nombre_recibe" placeholder="Nombre de quien recibe" required>
            
            <div class="SALIDA">
                <div class="btnCont"><button type="submit" class="btn dark">Enviar</button></div>
            </div>
        </form>
    </div>
    
    <div>
        <h2>ENTREGAS REGISTRADAS</h2>
        <table>
            <thead>
                <tr>
                    <th>ID DE ENTREGA</th>
                    <th>ID DEL PRODUCTO</th>
                    <th>NOMBRE PRODUCTO</th>
                    <th>ESTADO</th>
                    <th>CANTIDAD</th>
                    <th>FECHA ENTREGA</th>
                    <th>PERSONA QUE RECIBE</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_array($query)): ?>
                    <!-- Itera sobre los datos y muestra cada salida en la tabla -->
                    <tr>
                        <th><?= $row['id'] ?></th>
                        <th><?= $row['id_productos'] ?></th>
                        <th><?= $row['material'] ?></th>
                        <th><?= $row['estado'] ?></th>
                        <th><?= $row['cantidad'] ?></th>
                        <th><?= $row['fecha_salida'] ?></th>
                        <th><?= $row['nombre_recibe'] ?></th>
                        <th><a href="SALIDAS/update.php?id=<?= $row['id'] ?>" class="general-table-edit">Editar</a></th>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
