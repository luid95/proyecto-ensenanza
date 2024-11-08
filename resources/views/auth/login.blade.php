<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-sm p-8 bg-white rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Iniciar sesión</h2>

        @if ($errors->any())
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                <input type="email" name="email" id="email" class="w-full p-3 border border-gray-300 rounded mt-2" required>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" name="password" id="password" class="w-full p-3 border border-gray-300 rounded mt-2" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded">Iniciar sesión</button>
        </form>
    </div>
</div>

</body>
</html>
