<?php
include("./Configuration/security/headers.php");

include_once "./Configuration/Controllers/BranchesController.php";

if (isset($_POST['branchTrigger']) == true) {
    $callback = new BranchController();
    $callback->getBranch();
}
