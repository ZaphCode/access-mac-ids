<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function getAuthUser()
{
    return $_SESSION["user"] ?? null;
}

function isUserLogged()
{
    return isset($_SESSION["user"]);
}

function logout()
{
    session_destroy();
    header("Location: /public/account");
    exit();
}
