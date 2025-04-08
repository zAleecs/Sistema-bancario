<!-- recuperar.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Techzone</title>
    <link rel="stylesheet" href="main.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        form {
            background-color: #eee;
            width: 400px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            border: 1px solid blue; /* Borde verde */
        }

        .logo {
            display: block;
            margin: 0 auto 15px; /* Centra la imagen y agrega un espacio debajo */
            width: 100px; /* Ajusta el tamaño según necesites */
            height: auto; /* Mantiene la proporción de la imagen */
        }

        .recuperacion-container {
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        input[type="email"] {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: darkblue;
        }

        p {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <form action="procesar_recuperacion.php" method="POST">
        <img src="log.jpg" class="logo">
        <h1>Recuperar Contraseña</h1>
        <p><h4>Correo electrónico</h4></p>
        <input type="email" name="email" id="email" required>
        <p><button type="submit">Recuperar Contraseña</button></p>
        <p>Te enviaremos un enlace para cambiar tu contraseña.</p>
    </form>
</body>
</html>
