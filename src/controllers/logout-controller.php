<?php
require_once __DIR__ . "/../utils/imports.php";

if (isUserLogged()) {
    session_destroy();
}

header("Location: /public/");
exit();
