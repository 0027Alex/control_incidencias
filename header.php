<?php
// Inicia la sesión en cada página para poder acceder a las variables de sesión.
// session_start() debe llamarse antes de cualquier salida HTML.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- El título de la página se puede definir en cada archivo que incluya este header -->
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Control de Incidencias'; ?></title>
    
    <!-- CSS de Bootstrap 5 desde un CDN para un diseño rápido y responsivo -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Tu hoja de estilos personalizada (opcional) -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

    <!-- Barra de Navegación Principal -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Sistema de Incidencias</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Menú dinámico: cambia si el usuario está autenticado o no -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link" href="dashboard.php">Mi Panel</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Iniciar Sesión</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="container mt-4">
        <?php
        // Muestra mensajes "flash" (alertas temporales) si existen en la sesión.
        if (isset($_SESSION['flash_message'])) {
            $flash = $_SESSION['flash_message'];
            echo "<div class='alert alert-{$flash['type']} alert-dismissible fade show' role='alert'>";
            echo htmlspecialchars($flash['message']);
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo "</div>";
            // Elimina el mensaje de la sesión para que no se muestre de nuevo.
            unset($_SESSION['flash_message']);
        }
        ?>
