<?php
// Define el título de la página, que será usado en header.php
$page_title = 'Bienvenido';

// Incluye el encabezado de la página
include_once 'header.php';


// Si el usuario ya está logueado, redirígelo a su panel de control.
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}
?>

<div class="p-5 mb-4 bg-white rounded-3 shadow-sm text-center">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Sistema de Control de Incidencias</h1>
        <p class="col-md-8 fs-4 mx-auto">Bienvenido al portal de gestión de incidencias escolares. Por favor, inicie sesión para continuar.</p>
        <a class="btn btn-primary btn-lg" href="login.php">Iniciar Sesión</a>
    </div>
</div>

<?php
// Incluye el pie de página
include_once 'footer.php';

?>
