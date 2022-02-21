<?php
include("./Configuration/security/headers.php");

include_once "./Configuration/Controllers/Scanner.php";

if (isset($_POST['state']) == true) {
    $data = [
        'owner' => $_POST['owner']
    ];
    $callback = new ScannerController();
    $callback->GETPLATFORM($data);
}
