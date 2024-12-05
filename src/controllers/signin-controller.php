<?php
require_once __DIR__ . "/../utils/imports.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        header("Location: /public/account?error=2");
        exit();
    }

    try {
        $userStorage = new UserStorage(getPDO());
        $user = $userStorage->getUserByEmail($email);

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user"] = $user["email"];
            header("Location: /public/?success=1");
            exit();
        } else {
            header("Location: /public/account?error=1");
            exit();
        }
    } catch (\Throwable $th) {
        header("Location: /public/account?error=10");
        exit();
    }
} else {
    require_once __DIR__ . "/../views/account.php";
}
