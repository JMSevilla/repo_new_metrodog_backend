<?php
include("./Configuration/security/headers.php");

include_once "./Configuration/Controllers/QuestionsController.php";

if (isset($_POST['questionTrigger']) == true) {
    $callback = new QuestionController();
    $callback->getQuestion();
}
