<?php

include("./Configuration/security/headers.php");
include_once "./Configuration/Controllers/LoginController.php";

if (isset($_POST['logoutTrigger']) == true) {
    $data = [
        'owner' => $_POST['owner']
    ];
    $callback = new LoginCoreController();
    $callback->updateOnLogoutCore($data);
}
