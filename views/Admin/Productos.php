<?php
// Incluye el archivo "connect.php" que probablemente contiene la lógica de conexión a la base de datos.
include("../../models/connect.php");

// Llama a la función "connection()" del archivo "connect.php" para obtener una conexión a la base de datos.
$con = connection();

// Consulta SQL para seleccionar todos los registros de la tabla "productos".
$sql = "SELECT * FROM productos";

// Ejecuta la consulta SQL en la conexión a la base de datos y almacena el resultado en la variable $query.
$query = mysqli_query($con, $sql); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Enlaces a archivos CSS y configuración de metadatos de la página -->
    <link rel="stylesheet" href="../../assets/styles/barra1.css">
    <link rel="icon" type="image/png" href="../../assets/img/LOGO1.PNG">
    <link rel="stylesheet" href="../../assets/styles/Styleproductos1.css">
    <link rel="stylesheet" href="../../assets/styles/STYLETABLA1.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
</head>
<body>
    <header class="header">
        <div class="GENERAL">
            <div class="container">
                <a href=""><img src="../../assets/img/escudo1.png"  type="image/png"></a>
                <h1 class="titulo">Productos</h1>
            </div>
        </div>
    </header>
    <div class="form">
        <!-- Formulario para agregar nuevos productos. Los datos se envían a "../../controllers/Productos/producto.php" utilizando el método POST. -->
        <form action="../../controllers/Productos/producto.php" method="post" accept-charset="utf-8">
            <!-- Para tomar el valor del ID del producto -->
            <label>ID del producto</label>
            <input type="text" name="id" id="id" placeholder="ID del producto" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
            
            <!-- Para tomar el nombre del producto -->
            <label>Nombre del producto</label>
            <input type="text" name="nombre_producto" id="nombre_producto" placeholder="Nombre del producto">

            <!-- Para enviar el producto -->
            <div class="PRODUCTOS">
                <div class="btnCont">
                    <button type="submit" class="btn dark" name="enviar">Enviar</button>
                </div>
            </div>
        </form>
    </div>
    <div>
        <h1 class="titulo" >PRODUCTOS REGISTRADOS</h1>
        <!-- Tabla que mostrará los productos registrados -->
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Tipo</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <!-- Un bucle while que recorre los resultados de la consulta y muestra cada fila en la tabla. -->
                <?php while ($row = mysqli_fetch_array($query)): ?>
                    <tr>
                        <th><?= $row['id'] ?></th>
                        <th><?= $row['material'] ?></th>
                        <th><?= $row['cantidad_existentes'] ?></th>
                        <th><?= $row['tipo'] ?></th>
                        
                        <!-- Enlaces para editar y eliminar registros de la tabla. Los enlaces incluyen el ID del producto en la URL. -->
                        <th><a href="Productos/update.php?id=<?= $row['id'] ?>" class="general-table-edit">Editar</a></th>
                        <th><a href="../../controllers/Productos/delete.php?id=<?= $row['id'] ?>" class="general-table-delete">Eliminar</a></th>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
