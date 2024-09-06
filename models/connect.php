<?php
// Definición de la función de conexión a la base de datos
function connection(){
    // Definición de los detalles de la conexión
    $host = "localhost";  // Dirección del servidor de la base de datos (puede variar)
    $user = "root";       // Nombre de usuario de la base de datos
    $pass = "";           // Contraseña del usuario de la base de datos (en este caso, se deja en blanco)
    $db = "inventario";   // Nombre de la base de datos a la que se desea conectar

    // Establecer una conexión a la base de datos MySQL
    $connect = mysqli_connect($host, $user, $pass);

    // Seleccionar la base de datos en la conexión establecida
    mysqli_select_db($connect, $db);

    // Devolver el objeto de conexión a la base de datos
    return $connect;
}
?>
