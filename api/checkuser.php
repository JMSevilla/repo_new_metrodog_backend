<?php
include("./Configuration/security/headers.php");

include_once "./Configuration/Controllers/LoginController.php";

if (isset($_POST['trigger']) == 1) {
    $callback = new LoginController();
    $callback->checkUser();
}
