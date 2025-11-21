<!document html>
<html lang="es">
<head>
    <meta> charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-light">
// Incluye el archivo de configuración de la base de datos y las funciones.
require_once 'database.php';
require_once 'functions.php';

// Inicia la sesión para poder manejar las variables de sesión.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Si el usuario ya está logueado, no tiene sentido mostrarle el login, así que lo redirigimos.
if (isset($_SESSION['user_id'])) {
    redirect('dashboard.php');
}

// Procesa el formulario solo si se envió usando el método POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Busca al usuario en la base de datos por su email.
    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE email_usuario = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verifica si se encontró un usuario y si la contraseña coincide.
    // password_verify() es la función de PHP para comprobar contraseñas hasheadas con password_hash().
    if ($user && password_verify($password, $user['password_hash'])) {
        // Si las credenciales son correctas, guarda la información del usuario en la sesión.
        $_SESSION['user_id'] = $user['id_usuario'];
        $_SESSION['user_name'] = $user['nombre_usuario'];
        $_SESSION['user_role_id'] = $user['id_rol'];
        
        // Redirige al usuario a su panel de control.
        redirect('dashboard.php');
    } else {
        // Si las credenciales son incorrectas, prepara un mensaje de error.
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Correo o contraseña incorrectos. Inténtalo de nuevo.'
        ];
        redirect('login.php');
    }
}

// Define el título y carga el header.
$page_title = 'Iniciar Sesión';
require_once 'header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">Inicio de Sesión</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="login.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Carga el footer.
require_once 'includes/footer.php';

</html>
