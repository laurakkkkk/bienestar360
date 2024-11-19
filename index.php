<?php
session_start();
include 'config.php';

$message = "";  // Mensaje para mostrar el estado de registro o login

// Registro de usuario
if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (email, password) VALUES (:email, :password)";
    $stmt = $conn->prepare($sql);
    
    try {
        $stmt->execute(['email' => $email, 'password' => $password]);
        $message = "Registro exitoso. Ahora puedes iniciar sesión.";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $message = "Error: El email ya está registrado.";
        } else {
            $message = "Error al registrar usuario: " . $e->getMessage();
        }
    }
}

// Inicio de sesión de usuario
if (isset($_POST['login'])) {
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];

    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        header("Location: welcome.php");  // Redirigir a la página de bienvenida
        exit;
    } else {
        $message = "Credenciales incorrectas.";
    }
}

// Si el usuario está autenticado, redirigir a página de bienvenida
if (isset($_SESSION['user_id'])) {
    header("Location: welcome.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienestar360 - Registro y Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <header>
        <h1>Bienestar360</h1>
    </header>

    <main>
        <p class="message"><?= htmlspecialchars($message); ?></p>

        <div class="form-wrapper">
            <!-- Formulario de Registro -->
            <section class="form-container">
                <h2>Registro</h2>
                <form method="POST" action="index.php">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit" name="register">Registrar</button>
                </form>
            </section>

            <!-- Formulario de Login -->
            <section class="form-container">
                <h2>Login</h2>
                <form method="POST" action="index.php">
                    <label for="loginEmail">Email:</label>
                    <input type="email" id="loginEmail" name="loginEmail" required>

                    <label for="loginPassword">Contraseña:</label>
                    <input type="password" id="loginPassword" name="loginPassword" required>

                    <button type="submit" name="login">Iniciar Sesión</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
