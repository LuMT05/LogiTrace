<?php
// Incluir el archivo de conexión a la base de datos
include ("../../models/connect.php");

// Establecer la conexión a la base de datos
$con = connection();

// Consulta SQL para obtener información de las salidas y unir tablas relacionadas
$sql = "SELECT salidas.*, productos.* FROM salidas INNER JOIN productos ON salidas.id_productos = productos.id";

// Ejecutar la consulta
$query = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
    <head lang="es" xml:lang="es">
        <link rel="stylesheet" type="text/css" href="../../assets/styles/barra1.css">
        <link rel="stylesheet" href="../../assets/styles/STYLETABLA1.css">
        <link rel="icon" type="image/png" href="../../assets/img/LOGO1.PNG">
        <link rel="stylesheet" href="../../assets/styles/Stylegeneral1.css">
        <title>Salidas</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    </head>
<body>
    <header class="header">
        <div>
            <div class ="container">
                <a href="">
                    <img src="../../assets/img/escudo1.png"  type="image/png">
                </a>
                <h1 class="titulo">Artefactos</h1>
            </div>
        </div>
    </header>

    <div>
        <div class="form">
            <form action="../../controllers/Limpieza/SALIDAS/insertar.php" method="post" accept-charset="utf-8">
                <!-- Para ingresar el ID de la salida -->
                <label for="id">ID:</label>
                <input type="text" name="id" id="id" placeholder="ID de la salida" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                <!-- Para ingresar el ID del producto -->
                <label for="opcion">ID producto:</label>
                <input type="text" name="id_productos" id="id_productos" placeholder="ID del producto" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                <!-- Para seleccionar el estado del producto -->
                <label for="opcion">Estado del producto:</label>
                <select name="opcion" id="opcion">
                    <option value="nuevo">Nuevo</option>
                    <option value="usado">Usado</option>
                    <option value="dañado">Dañado</option>
                </select>
                <!-- Para ingresar la fecha de salida -->
                <label for="fecha">Fecha de entregado:</label>
                <input type="date" id="fecha" name="fecha">
                <!-- Para ingresar la cantidad a salir -->
                <label>Cantidad a entregar</label>
                <input type="number" name="cantidad" id="cantidad" placeholder="Cantidad a salir" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                <!-- Para ingresar el nombre de la persona que recibe -->
                <label>Nombre de quien recibe</label>
                <input type="text" name="nombre_recibe" id="nombre_recibe" placeholder="Nombre de quien recibe" required>
                <!-- Para enviar la salida -->
                <div class="SALIDA">
                    <div class="btnCont">
                        <button type="submit" class="btn dark">Enviar</button>
                    </div>
                </div>
            </form>
        </div>
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
                <?php while($row = mysqli_fetch_array($query)):?>
                    <tr>
                        <!-- Imprimir los datos de las salidas registradas -->
                        <th><?=$row['id']?></th>
                        <th><?=$row['id_productos']?></th>
                        <th><?=$row['material']?></th>
                        <th><?=$row['estado']?></th>
                        <th><?=$row['cantidad']?></th>
                        <th><?=$row['fecha_salida']?></th>
                        <th><?=$row['nombre_recibe']?></th>
                        <th><a href="SALIDAS/update.php?id=<?=$row['id']?>" class="general-table-edit">Editar</a></th>
                    </tr>
                <?php endwhile;?>
            </tbody>
        </table>
    </div>
</body>
</html>
