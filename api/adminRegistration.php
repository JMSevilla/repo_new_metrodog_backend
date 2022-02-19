<?php
include("./Configuration/security/headers.php");
include_once "./Configuration/Controllers/AdminRegistrationController.php";

if (isset($_POST['admintrigger']) == 1) {
    $data = [
        "fname" => $_POST['firstname'],
        "lname" => $_POST['lastname'],
        "PA" => $_POST['primary_address'],
        "SA" => $_POST['secondary_address'],
        "CN" => $_POST['contactNumber'],
        "email" => $_POST['email'],
        "username" => $_POST['username'], "pwd" => $_POST['password'], "SQ" => $_POST['sec_question'],
        "secA" => $_POST['sec_answer'], "branch" => $_POST['mdbranch']
    ];
    $callback = new AdminRegistrationController();
    $callback->IadminController($data);
}
