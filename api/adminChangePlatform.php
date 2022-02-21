<?php

include("./Configuration/security/headers.php");

include_once "./Configuration/Controllers/LoginController.php";

if (isset($_POST['platformTrigger']) == true) {
    $data = [
        'owner' => $_POST['owner']
    ];
    $callback = new LoginCoreController();
    $callback->updateOnAdminChangePlatform($data);
}
