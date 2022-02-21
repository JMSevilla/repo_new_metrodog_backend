<?php

include("./Configuration/security/headers.php");
include_once "./Configuration/Controllers/LoginController.php";

if (isset($_POST['loginTrigger']) == 1) {
    $data = [
        "uname" => $_POST['username'],
        "password" => $_POST['password']
    ];
    $callback = new LoginCoreController();
    $callback->ClientLogin($data);
}


if (isset($_POST['state']) == true) {

    $callback = new Tokenization();
    $callback->tokenIdentify($_POST['owner']);
}
