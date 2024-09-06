<?php
// Incluir el archivo de conexión a la base de datos
include ("../../models/connect.php");

// Establecer la conexión a la base de datos
$con = connection();

// Consulta SQL para obtener información de las entradas y unir tablas relacionadas
$sql = "SELECT entradas.*, productos.material, productos.tipo, unidades.descripcion, proveedor.nombre_contacto 
        FROM entradas 
        INNER JOIN productos ON entradas.id_productos = productos.id 
        INNER JOIN unidades ON entradas.cod_unidad = unidades.codigo
        INNER JOIN proveedor ON entradas.Nit_Proveedor = proveedor.nit";

// Ejecutar la consulta
$query = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
    <head lang="es" xml:lang="es">
        <head lang="es" xml:lang="es">
            <link rel="stylesheet" type="text/css" href="../../assets/styles/barra1.css">
            <link rel="icon" type="image/png" href="../../assets/img/LOGO1.PNG">
            <link rel="stylesheet" href="../../assets/styles/Stylegeneral1.css">
            <link rel="stylesheet" href="../../assets/styles/STYLETABLA1.css">
            <title>Entradas</title>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        </head>
<body>
    <header class="header">
        <div>
            <div class="container">
                <a href=""><img src="../../assets/img/escudo1.png" type="image/png"></a>
                <h1 class="titulo">Artecfactos</h1>
            </div>
        </div>
    </header>
    
    <div>
        <div class="form">
        <form action="../../controllers/Limpieza/Entradas/insertar.php" method="post" accept-charset="utf-8">
            <!-- Para ingresar el ID de la entrada -->
            <label for="opcion">ID:</label>
            <input type="text" name="id" id="id" placeholder="ID de la entrada" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
            
            <!-- Para ingresar el ID del producto -->
            <label for="opcion">ID producto:</label>
            <input type="text" name="id_productos" id="id_productos" placeholder="ID del producto ingresado" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
            
            <!-- Para ingresar el ID del proveedor -->
            <label for="opcion">ID proveedor:</label>
            <input type="text" name="id_proveedor" id="id_proveedor" placeholder="ID del proveedor" required>
            
            <!-- Para seleccionar el estado del producto -->
            <label for="opcion">Estado del producto:</label>
            <select name="opcion" id="opcion">
                <option value="nuevo">Nuevo</option>
                <option value="usado">Usado</option>
                <option value="dañado">Dañado</option>
            </select>
            
            <!-- Para ingresar la cantidad de entrada -->
            <label>Cantidad entrada</label>
            <input type="number" name="cant_Salida" id="cant_Salida" placeholder="Cantidad de entrada" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
            
            <!-- Para ingresar el ID de la unidad de salida -->
            <label>ID unidad de salida</label>
            <input type="number" name="id_unidades" id="id_unidades" placeholder="ID de la unidad de salida" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
            
            <!-- Para ingresar la fecha de ingreso -->
            <label for="fecha">Fecha ingreso:</label>
            <input type="date" id="fecha" name="fecha">
            
            <!-- Para ingresar la hora de ingreso -->
            <label for="hora">Hora ingreso (00:00/24:00):</label>
            <input type="time" id="hora" name="hora">
            
            <!-- Para enviar la entrada -->
            <div class="ENTRADA">
                <div class="btnCont"><button type="submit" class="btn dark">Enviar</button> </div>
            </div>
        </form>
        </div>
    </div>

    <div>
        <h2>ENTRADAS REGISTRADAS</h2>
        <table>
            <thead>
                <tr>
                    <th>ID DE ENTRADA</th>
                    <th>ID DEL PRODUCTO</th>
                    <th>NOMBRE PRODUCTO</th>
                    <th>NIT EMPRESA</th>
                    <th>CONTACTO PROVEEDOR</th>
                    <th>TIPO</th>
                    <th>ESTADO</th>
                    <th>CANTIDAD</th>
                    <th>CODIGO UNIDAD</th>
                    <th>FECHA INGRESO</th>
                    <th>HORA</th>
                    <th></th>
                </tr>
            </thead>
            <tbody> 
                <?php while ($row = mysqli_fetch_array($query)):?>
                    <tr>
                        <!-- Imprimir los datos de las entradas registradas -->
                        <th> <?=$row['Id'] ?> </th>
                        <th> <?=$row['id_productos'] ?> </th>
                        <th> <?=$row['material'] ?> </th>
                        <th> <?=$row['Nit_Proveedor'] ?> </th>
                        <th> <?=$row['nombre_contacto'] ?> </th>
                        <th> <?=$row['tipo'] ?> </th>
                        <th> <?=$row['estado'] ?> </th>
                        <th> <?=$row['cantidad'] ?> </th>
                        <th> <?=$row['descripcion'] ?> </th>
                        <th> <?=$row['fecha_ingreso'] ?> </th>
                        <th> <?=$row['hora'] ?> </th>
                        <th><a href="Entradas/update.php?Id=<?=$row['Id'] ?>" class="general-table-edit">Editar</a></th>
                    </tr>
                <?php endwhile;?>
            </tbody>
        </table>
    </div>
</body>
</html>
