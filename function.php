<?php
// includes/functions.php

/**
 * Redirige al usuario a una página específica.
 *
 * @param string $url La URL a la que se va a redirigir.
 * @return void
 */
function redirect($url) {
    header("Location: $url");
    exit(); // Detiene la ejecución del script actual después de la redirección.
}

/**
 * Verifica si un usuario está autenticado. Si no, lo redirige a la página de login.
 *
 * @return void
 */
function ensure_is_authenticated() {
    // session_status() verifica el estado de la sesión actual.
    // PHP_SESSION_NONE significa que las sesiones están habilitadas, pero ninguna ha sido iniciada.
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); // Inicia la sesión si no está iniciada.
    }

    // Comprueba si la variable de sesión 'user_id' no está definida.
    // Esta variable solo se define cuando el usuario inicia sesión correctamente.
    if (!isset($_SESSION['user_id'])) {
        // Guarda un mensaje de error en la sesión para mostrarlo en la página de login.
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Debes iniciar sesión para acceder a esta página.'
        ];
        redirect('login.php');
    }
}
?>
