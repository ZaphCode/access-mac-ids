<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/public/scripts/login.js" defer></script>
    <title>Document</title>
</head>

<body class="bg-gray-100">
    <nav class="flex justify-center py-1.5 items-center px-4 bg-black w-full">
        <div class="">
            <a href="/public/">
                <img src="/public/assets/logo.png" class="w-44" alt="logo">
            </a>
        </div>
    </nav>
    <main class="flex flex-col items-center mt-14">
        <div>
            <button id="signin-btn" class="text-gray-600">Sing in</button>
            <span class="text-2xl text-gray-300 mx-2 -mb-1">/</span>
            <button id="signup-btn" class="text-gray-600">Sing up</button>
        </div>
        <div class="h-52 w-2/3 max-w-xl border-gray-300 mt-4 border-t-2 min-w-48">
            <?php if (isset($_GET["error"])) : ?>
                <div id="error-div" class="bg-red-700 w-1/2 text-sm py-2 mx-auto mt-4 text-center rounded-sm text-white">
                    <?php
                    switch ($_GET['error']) {
                        case 1:
                            echo "⚠️ Correo o contraseña incorrectos.";
                            break;
                        case 2:
                            echo "⚠️ Todos los campos son obligatorios.";
                            break;
                        case 3:
                            echo "⚠️ Las contraseñas no coinciden.";
                            break;
                        case 4:
                            echo "⚠️ El correo ya está registrado.";
                            break;
                        default:
                            echo "⚠️ Algo salió mal.";
                            break;
                    }
                    ?>
                </div>
            <?php endif; ?>
            <!-- Sign in -->
            <div id="signin-form" class="mt-1 hidden">
                <form action="/signin" method="POST" class="flex flex-col items-center">
                    <input type="email" name="email" placeholder="Email" class="w-72 h-10 border-2 border-gray-300 rounded-md px-2 mt-5">
                    <input type="password" name="password" placeholder="Password" class="w-72 h-10 border-2 border-gray-300 rounded-md px-2 mt-5">
                    <button type="submit" class="w-72 h-10 bg-black text-yellow-200 rounded-md mt-5">Sign in</button>
                    <p class="pt-5 text-gray-400 text-sm">Don't account yet? <button id="register" class="font-bold">Register</button></p>
                </form>
            </div>
            <!-- Sign up -->
            <div id="signup-form" class="mt-1 hidden">
                <form action="/signup" method="POST" class="flex flex-col items-center">
                    <input type="text" name="username" placeholder="Username" class="w-72 h-10 border-2 border-gray-300 rounded-md px-2 mt-5">
                    <input type="email" name="email" placeholder="Email" class="w-72 h-10 border-2 border-gray-300 rounded-md px-2 mt-5">
                    <input type="password" name="password" placeholder="Password" class="w-72 h-10 border-2 border-gray-300 rounded-md px-2 mt-5">
                    <input type="password" name="confirm_password" placeholder="Confirm password" class="w-72 h-10 border-2 border-gray-300 rounded-md px-2 mt-5">
                    <button type="submit" class="w-72 h-10 bg-black text-yellow-200 rounded-md mt-5">Sign up</button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>