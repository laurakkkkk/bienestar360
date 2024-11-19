<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_email = $_SESSION['user_email'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienestar360 - Bienvenida</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Menú de navegación -->
    <nav class="navbar">
        <div class="nav-container">
            <span class="nav-logo">Bienestar360</span>
            <ul class="nav-links">
                <li><a href="#reflexiones">Reflexiones</a></li>
                <li><a href="#recursos">Recursos</a></li>
                <li><a href="#formulario">Formulario</a></li>
                <li><a href="logout.php" class="logout-link">Cerrar Sesión</a></li>
            </ul>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main>
        <header class="welcome-header">
            <h1>Bienvenido a Bienestar360</h1>
            <p>Hola, <?= htmlspecialchars($user_email); ?>.</p>
        </header>

        <section id="reflexiones" class="welcome-section">
            <h2>Reflexiones para tu bienestar</h2>
            <ul>
                <li>"Cuida de ti mismo. Es importante dar a los demás, pero no te olvides de ti."</li>
                <li>"La paz mental comienza en el momento en que decides no permitir que otra persona o evento controle tus emociones."</li>
                <li>"Eres suficiente. Cada paso que das hacia adelante es valioso."</li>
            </ul>
        </section>

        <section id="recursos" class="resources-section">
            <h2>Recursos para el Autocuidado</h2>
            <ul>
                <li>Practica la respiración consciente durante 5 minutos al día.</li>
                <li>Toma un descanso cada hora para relajarte y estirarte.</li>
                <li>Establece una rutina de sueño saludable.</li>
            </ul>
        </section>

        <section id="formulario" class="self-care-form-section">
            <h2>Formulario de Reflexión sobre el Autocuidado</h2>
            <form action="self_care.php" method="POST">
                <label for="sleep">¿Cuántas horas duermes en promedio cada noche?</label>
                <input type="number" id="sleep" name="sleep" required>

                <label for="exercise">¿Realizas alguna actividad física semanalmente? ¿Cuál?</label>
                <input type="text" id="exercise" name="exercise" required>

                <label for="mood">Describe tu estado de ánimo en los últimos días:</label>
                <textarea id="mood" name="mood" rows="4" required></textarea>

                <label for="goals">¿Tienes alguna meta personal de autocuidado para esta semana?</label>
                <textarea id="goals" name="goals" rows="4"></textarea>

                <button type="submit">Enviar Reflexión</button>
            </form>
        </section>
    </main>
</body>
</html>
