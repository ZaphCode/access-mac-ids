<?php
require_once __DIR__ . "/../utils/imports.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        header("Location: /public/account?error=2&mode=signup");
        exit();
    }

    if ($password !== $confirmPassword) {
        header("Location: /public/account?error=3&mode=signup");
        exit();
    }

    try {
        $userStorage = new UserStorage(getPDO());

        $existingUser = $userStorage->getUserByEmail($email);
        if ($existingUser) {
            header("Location: /public/account?error=4&mode=signup");
            exit();
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $userStorage->createUser($username, $email, $hashedPassword);

        header("Location: /public/?success=1");
        exit();
    } catch (\Throwable $th) {
        header("Location: /public/account?error=10");
        exit();
    }
} else {
    require_once __DIR__ . "/../views/account.php";
}
