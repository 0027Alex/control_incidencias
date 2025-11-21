<?php
// Inicia la sesión para poder acceder a ella.
session_start();

// session_unset() libera todas las variables de sesión.
session_unset();

// session_destroy() destruye toda la información registrada de una sesión.
session_destroy();

// Inicia una nueva sesión solo para guardar el mensaje flash.
session_start();
$_SESSION['flash_message'] = [
    'type' => 'success',
    'message' => 'Has cerrado sesión correctamente.'
];

// Redirige al usuario a la página de inicio.
header('Location: index.php');
exit();
?>
