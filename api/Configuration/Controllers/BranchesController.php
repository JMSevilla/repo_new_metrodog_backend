<?php

include_once __DIR__ . "/db.php";
include_once __DIR__ . "/queries.php";

interface IBranches
{
    public function getBranch();
}

class BranchController extends DatabaseMigration implements IBranches
{
    public function getBranch()
    {
        $serverChecker = new Server();
        $QueryIdentifier = new Queries();
        if ($serverChecker->POSTCHECKER()) {
            if ($this->php_query($QueryIdentifier->fetchAllBranch('fetch/branchName'))) {
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
