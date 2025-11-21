<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

// Asegura que el usuario esté autenticado para poder ver esta página.
ensure_is_authenticated();

// Obtiene el rol del usuario desde la base de datos.
$stmt = $pdo->prepare("SELECT r.nombre_rol FROM rol r JOIN usuario u ON r.id_rol = u.id_rol WHERE u.id_usuario = ?");
$stmt->execute([$_SESSION['user_id']]);
$user_role = $stmt->fetchColumn(); // fetchColumn() devuelve el valor de una sola columna.

// --- LÓGICA DE ADVERTENCIAS PARA ESTUDIANTES ---
if ($user_role === 'Estudiante') {
    // 1. Encontrar el ID del estudiante asociado al usuario actual.
    //    (Asumimos una relación por email o nombre, esto debería ser un FK en un sistema real)
    $stmt_student = $pdo->prepare("SELECT id_estudiante FROM estudiante WHERE nie = ?"); // Asumiendo que el NIE es el email del usuario
    $stmt_student->execute([$_SESSION['user_email']]); // Necesitarías guardar el email en la sesión al hacer login
    $student_id = $stmt_student->fetchColumn();

    if ($student_id) {
        // 2. Contar los deméritos del estudiante.
        $stmt_demerits = $pdo->prepare("SELECT COUNT(*) FROM demerito WHERE id_estudiante = ?");
        $stmt_demerits->execute([$student_id]);
        $demerits_count = $stmt_demerits->fetchColumn();

        // 3. Definir el mensaje de advertencia según la cantidad de deméritos.
        $warning_message = '';
        if ($demerits_count >= 15) {
            $warning_message = "15 deméritos: El estudiante no podrá ser promovido de grado.";
        } elseif ($demerits_count > 10) {
            $warning_message = "Más de 10 deméritos: reunión con la dirección y la familia, acompañada de una última advertencia.";
        } elseif ($demerits_count == 10) {
            $warning_message = "10 deméritos: suspensión de privilegios escolares.";
        } elseif ($demerits_count >= 6) {
            $warning_message = "6 deméritos: comunicación a la familia y tarea correctiva.";
        } elseif ($demerits_count >= 3) {
            $warning_message = "3 deméritos: advertencia verbal y reflexión escrita.";
        }
        
        // Guarda el mensaje en la sesión para mostrarlo en el dashboard del estudiante.
        $_SESSION['demerits_count'] = $demerits_count;
        $_SESSION['warning_message'] = $warning_message;
    }
}

// --- REDIRECCIÓN BASADA EN ROL ---
// Dependiendo del rol, redirige a la página de dashboard correspondiente.
// (Por ahora, solo mostramos un mensaje genérico, pero esto se puede expandir)
$page_title = 'Mi Panel';
require_once 'includes/header.php';

echo "<h1>Bienvenido a tu panel, " . htmlspecialchars($_SESSION['user_name']) . "!</h1>";
echo "<p>Tu rol es: <strong>" . htmlspecialchars($user_role) . "</strong></p>";

// Muestra la advertencia si es un estudiante y tiene una.
if ($user_role === 'Estudiante' && !empty($_SESSION['warning_message'])) {
    echo "<div class='alert alert-warning mt-4' role='alert'>";
    echo "<h4 class='alert-heading'>¡Atención!</h4>";
    echo "<p>Tienes un total de <strong>{$_SESSION['demerits_count']}</strong> deméritos.</p>";
    echo "<hr>";
    echo "<p class='mb-0'>" . htmlspecialchars($_SESSION['warning_message']) . "</p>";
    echo "</div>";
}

require_once 'includes/footer.php';
?>
