<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticación</title>
    <script>
        // Esperar a que la ventana principal esté disponible
        window.onload = function() {
            if (window.opener) {
                // Enviar el token a la ventana principal
                window.opener.postMessage({ token: "{{ $token }}", user: @json($user) }, "http://localhost:5173");
                window.opener.postMessage({ token: "{{ $token }}", user: @json($user) }, "http://localhost:5174");

                
                window.close(); // Cerrar el popup automáticamente
            }
        };
    </script>
</head>
<body>
    <p>Autenticando...</p>
</body>
</html>
