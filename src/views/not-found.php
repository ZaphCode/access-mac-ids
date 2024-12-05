<?php
include __DIR__ . "/../utils/imports.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . "/layout/header_links.php"; ?>
    <title>Not found</title>
</head>

<body>
    <?php include __DIR__ . "/layout/navbar.php"; ?>
    <main class="flex flex-col items-center justify-center">
        <div>
            <img class="max-w-xs" src="https://cdn3d.iconscout.com/3d/premium/thumb/404-error-3d-icon-download-in-png-blend-fbx-gltf-file-formats--page-not-found-cyber-security-pack-device-icons-7358321.png" alt="404">
        </div>
        <p class="text-xl text-gray-600 -m-3 mb-6">Ooops! Page not found</p>
        <a href="/public" class="text-yellow-100 px-7 py-3 bg-black cursor-pointer">Back to Home</a>
    </main>
</body>

</html>