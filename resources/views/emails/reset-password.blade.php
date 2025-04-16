<!DOCTYPE html>
<html>
<head>
    <title>Recuperar contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        h1 {
            color: #2d3748;
        }
        .btn {
            display: inline-block;
            background-color: #3490dc;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #718096;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Recuperación de contraseña</h1>
        
        <p>Hola,</p>
        
        <p>Has solicitado restablecer tu contraseña. Haz clic en el siguiente enlace para continuar:</p>
        
        <p>
            <a href="{{ $resetUrl }}" class="btn">Restablecer contraseña</a>
        </p>
        
        <p>Si no puedes hacer clic en el botón, copia y pega esta URL en tu navegador:</p>
        <p>{{ $resetUrl }}</p>
        
        <p>Este enlace caducará en 24 horas.</p>
        
        <p>Si no has solicitado este cambio, puedes ignorar este correo y tu contraseña actual seguirá siendo válida.</p>
        
        <div class="footer">
            <p>Saludos,<br>El equipo de {{ config('app.name', 'Laravel') }}</p>
        </div>
    </div>
</body>
</html>