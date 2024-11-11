<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-sm p-8 bg-white rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Registro de nuevo usuario</h2>

        @if ($errors->any())
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre completo</label>
                <input type="text" name="name" id="name" class="w-full p-3 border border-gray-300 rounded mt-2" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                <input type="email" name="email" id="email" class="w-full p-3 border border-gray-300 rounded mt-2" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" name="password" id="password" class="w-full p-3 border border-gray-300 rounded mt-2" required>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-3 border border-gray-300 rounded mt-2" required>
            </div>

            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                <select name="role" id="role" class="w-full p-3 border border-gray-300 rounded mt-2">
                    <option value="user">Usuario</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded">Registrarse</button>
        </form>

        <!-- Enlace para volver al inicio de sesión -->
        <div class="mt-6 text-center">
            <p>¿Ya tienes una cuenta? 
                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Inicia sesión aquí</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>
