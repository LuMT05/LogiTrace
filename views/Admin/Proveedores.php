<?php
// Incluye el archivo "connect.php" que probablemente contiene la lógica de conexión a la base de datos.
include("../../models/connect.php");

// Llama a la función "connection()" del archivo "connect.php" para obtener una conexión a la base de datos.
$con = connection();

// Consulta SQL para seleccionar todos los registros de la tabla "proveedor".
$sql = "SELECT * FROM proveedor";

// Ejecuta la consulta SQL en la conexión a la base de datos y almacena el resultado en la variable $query.
$query = mysqli_query($con, $sql); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Enlaces a archivos CSS y configuración de metadatos de la página -->
    <link rel="stylesheet" href="../../assets/styles/barra1.css">
    <link rel="icon" type="image/png" href="../../assets/img/LOGO1.PNG">
    <link rel="stylesheet" href="../../assets/styles/STYLETABLA1.css">
    <link rel="stylesheet" href="../../assets/styles/Styleproductos1.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores</title>
</head>
<body>
    <header class="header">
        <div>
            <div class="container">
                <a href=""><img src="../../assets/img/escudo1.png"  type="image/png"></a>
                <h1 class="titulo">Proveedores</h1>
            </div>
        </div>
    </header>
    <div class="form">
        <!-- Formulario para agregar nuevos proveedores. Los datos se envían a "../INSERT/Proveedores.php" utilizando el método POST. -->
        <form action="../../controllers/Proveedores/Proveedores.php" method="post" accept-charset="utf-8">
            <label>Nit de la empresa</label>
            <!-- Para tomar el NIT de la empresa -->
            <input type="text" name="NIT" id="NIT" placeholder="NIT de la empresa" required>
            <label>Nombre de la empresa</label>
            <!-- Para tomar el nombre de la empresa -->
            <input type="text" name="nombre_empresa" id="nombre_empresa" placeholder="Nombre de la empresa" required>
            <label>Nombre proveedor</label>
            <!-- Para tomar el nombre del proveedor -->
            <input type="text" name="nombre_proveedor" id="nombre_proveedor" placeholder="Nombre del proveedor" required>
            <label>Direccion proveedor</label>
            <!-- Para tomar la dirección del proveedor -->
            <input type="text" name="direccion" id="direccion" placeholder="Dirección del proveedor" required>
            <label>Telefono proveedor</label>
            <!-- Para tomar el teléfono del proveedor -->
            <input type="number" name="telefono" id="telefono" placeholder="Telefono del proveedor" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
            <!-- Para enviar la información del proveedor -->
            <div class="PROVEEDOR">
                <div class="btnCont">
                    <button type="submit" class="btn dark" name="enviar">Enviar</button>
                </div>
            </div>
        </form>
    </div>
    <div>
        <h1>PROVEEDORES REGISTRADOS</h1>
        <!-- Tabla que mostrará los proveedores registrados -->
        <table>
            <thead>
                <tr>
                    <th>NIT</th>
                    <th>EMPRESA</th>
                    <th>NOMBRE DE CONTACTO</th>
                    <th>DIRECCION</th>
                    <th>TELEFONO DE CONTACTO</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <!-- Un bucle while que recorre los resultados de la consulta y muestra cada fila en la tabla. -->
                <?php while($row = mysqli_fetch_array($query)): ?>
                    <tr>
                        <th><?= $row['nit'] ?></th>
                        <th><?= $row['empresa'] ?></th>
                        <th><?= $row['nombre_contacto'] ?></th>
                        <th><?= $row['direccion'] ?></th>
                        <th><?= $row['telefono_contacto'] ?></th>
                        <!-- Enlaces para editar y eliminar registros de la tabla. Los enlaces incluyen el NIT de la empresa en la URL. -->
                        <th><a href="Proveedores/update.php?nit=<?= $row['nit'] ?>" class="general-table-edit">Editar</a></th>
                        <th><a href="../../controllers/Proveedores/delete.php?nit=<?= $row['nit'] ?>" class="general-table-delete">Eliminar</a></th>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
