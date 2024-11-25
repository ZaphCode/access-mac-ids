<?php

function getPDO(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $user = "gato-salvaje";
        $password = "gato-salvaje-123";

        try {
            $pdo = new PDO("mysql:host=db;dbname=access-mac-db;charset=utf8", $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    return $pdo;
}
