<?php


include("./Configuration/security/headers.php");
include_once "./Configuration/Controllers/cookie.php";

if (isset($_POST['scanCookie']) == true) {
    $arguement = new ScanCookie();
    $arguement->cookieScanner($_POST['tokenName']);
}
