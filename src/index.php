<!DOCTYPE html>
<html lang="en">
<?php
require_once "utils/database.php";

$pdo = getPDO();
$stmt = $pdo->query("SELECT VERSION()");
$version = $stmt->fetchColumn();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="public/scripts/index.js" defer></script>
    <title>Document</title>ma
</head>

<body>
    <h2>Hello World! 👋🌎</h2>
    <i><?php echo "Versión de MySQL: $version"; ?></i>
    <p>Esta es una página de prueba, solo para verificar la correcta conexión de la base de datos.</p>
    <button onclick="handleClick()">Click Me</button>
</body>

</html>