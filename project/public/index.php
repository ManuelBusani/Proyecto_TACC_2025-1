<!-- formulario de login -->
<!-- mostramos formulario simple con campos para email y constraseña -->
<!-- si tenemos un error guardado en $_SESSION['error'] lo mostramos -->
<!-- envíamos el formulario por POST a ../actions/login.php, donde procesaremos la autenticación -->
<!-- index.php -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <style>
        
        body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        padding: 50px;
        }
        
        .login-container {
        background: white;
        max-width: 400px;
        margin: auto;
        padding: 30px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        border-radius: 10px;
        }
        
        .login-container h2 {
        text-align: center;
        }
        
        .login-container input[type="email"],
        
        .login-container input[type="password"] {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
        }
        
        .login-container button {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        }
        
        .login-container button:hover {
        background-color: #45a049;
        }
        
        .error {
        color: red;
        text-align: center;
        }

        #googleAuth {
            max-width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }

    </style>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
        function handleCredentialResponse(response) {
            fetch('../actions/google_login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ credential: response.credential })
            })
            .then(res => res.text())
            .then(text => {
                console.log("Respuesta cruda del servidor:", text);
                try {
                    const data = JSON.parse(text);
                    if (data.success) {
                        window.location.href = '../public/dashboard.php';
                    } else {
                        alert('Fallo en el login');
                    }
                } catch (e) {
                    console.error("Error al parsear JSON:", e);
                }
            });

        }

        window.onload = function () {
        google.accounts.id.initialize({
            client_id: '964633068946-rer6fh6j09259582nd89ci582ngnjp7i.apps.googleusercontent.com',
            callback: handleCredentialResponse
        });

        google.accounts.id.renderButton(
            document.getElementById("googleAuth"),  
            { theme: "outline", size: "large",  }
        );
      };
    </script>

</head>
<body>
    <div class="login-container">
        <h2>Iniciar sesión</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <p class="error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <form action="../actions/login.php" method="POST">
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Entrar</button>
        </form>

        <div class="register-link">
            <p>¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p>
        </div>

        <div id="googleAuth"></div>
     </div>
</body>
</html>