<?php 
    # Variables de configuración de la base
$host =     "localhost";
$port =     "5432";
$dbname =   "control_incidencias"; // Reemplaza esto
$user =     "postgres";       // Reemplaza esto
$password = "bootcamp2025"; // Reemplaza esto
    $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Error de conexión a PostgreSQL: " . pg_last_error());
}
?>