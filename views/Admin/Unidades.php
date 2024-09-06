<?php
// Incluye el archivo "connect.php" que probablemente contiene la lógica de conexión a la base de datos.
include("../../models/connect.php");

// Llama a la función "connection()" del archivo "connect.php" para obtener una conexión a la base de datos.
$con = connection();

// Consulta SQL para seleccionar todos los registros de la tabla "unidades".
$sql = "SELECT * FROM unidades";

// Ejecuta la consulta SQL en la conexión a la base de datos y almacena el resultado en la variable $query.
$query = mysqli_query($con, $sql); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Enlaces a archivos CSS y configuración de metadatos de la página -->
    <link rel="stylesheet" href="../../assets/styles/barra1.css">
    <link rel="icon" type="image png" href="../../assets/img/LOGO1.PNG">
    <link rel="stylesheet" href="../../assets/styles/Styleproductos1.css">
    <link rel="stylesheet" href="../../assets/styles/STYLETABLA1.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unidades</title>
</head>
<body>
    <header class="header">
        <div>
            <div class="container">
                <a href=""><img src="../../assets/img/escudo1.png" type="image/png"></a>
                <h1 class="titulo">Unidades</h1>
            </div>
        </div>
    </header>
    <div class="form">
        <!-- Formulario para agregar nuevas unidades. Los datos se envían a "../INSERT/unidades.php" utilizando el método POST. -->
        <form action="../../controllers/Unidades/unidades.php" method="post" accept-charset="utf-8">
            <label>Identificador de la unidad</label>
            <!-- Para tomar el ID de la unidad -->
            <input type="number" name="Id_Unidad" id="Id_Unidad" placeholder="Identificador de unidad" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
            <label>Descripcion</label>
            <!-- Para tomar el nombre de la unidad -->
            <input type="text" name="nombre_unidad" id="nombre_unidad" placeholder="Ingrese la unidad" required>

            <!-- Para enviar la información de las unidades -->
            <div class="UNIDAD">
                <div class="btnCont">
                    <button type="submit" class="btn dark" name="enviar">Enviar</button>
                </div>
            </div>
        </form>
    </div>
    <div>
        <h1>UNIDADES REGISTRADAS</h1>
        <!-- Tabla que mostrará las unidades registradas -->
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Descripcion</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <!-- Un bucle while que recorre los resultados de la consulta y muestra cada fila en la tabla. -->
                <?php while ($row = mysqli_fetch_array($query)): ?>
                    <tr>
                        <th><?= $row['codigo'] ?></th>
                        <th><?= $row['descripcion'] ?></th>
                        <!-- Enlaces para editar y eliminar registros de la tabla. Los enlaces incluyen el ID de la unidad en la URL. -->
                        <th><a href="Unidades/update.php?codigo=<?= $row['codigo'] ?>" class="general-table-edit">Editar</a></th>
                        <th><a href="../../controllers/Unidades/delete.php?codigo=<?= $row['codigo'] ?>" class="general-table-delete">Eliminar</a></th>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
