<?php

include_once __DIR__ . "/db.php";
include_once __DIR__ . "/queries.php";

interface IQuestions
{
    public function getQuestion();
}

class QuestionController extends DatabaseMigration implements IQuestions
{
    public function getQuestion()
    {
        $serverChecker = new Server();
        $QueryIdentifier = new Queries();
        if ($serverChecker->POSTCHECKER()) {
            if ($this->php_query($QueryIdentifier->fetchAllQuestions('fetch/questions'))) {
                $this->php_exec();
                if ($this->php_row_checker()) {
                    $get = $this->php_fetchAll();
                    echo $this->php_responses(
                        true,
                        "single",
                        array("key" => $get)
                    );
                }
            }
        }
    }
}
