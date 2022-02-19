<?php

include_once __DIR__ . "/db.php";
include_once __DIR__ . "/queries.php";


interface IAdminRegController
{
    public function IadminController($data);
    public function UserManagementController($data);
    public function IFetchController();
    public function IFetchBranchController();
}

class AdminRegistrationController extends DatabaseMigration implements IAdminRegController
{
    public function IadminController($data)
    {
        $serverHelper = new Server();
        $queryIndicator = new Queries();
        if ($serverHelper->POSTCHECKER()) {
            if ($this->php_prepare($queryIndicator->InsertAdminReg("users", "adminReg"))) {
                $this->php_bind(":fname", $data['fname']);
                $this->php_bind(":lname", $data['lname']);
                $this->php_bind(":uname", $data['username']);
                $this->php_bind(":pwd", $this->php_encrypt_password($data['pwd']));
                $this->php_bind(":uType", '1');
                $this->php_bind(":uStatus", '1');
                $this->php_bind(":imgURL", 'None');
                $this->php_bind(":PA", $data['PA']);
                $this->php_bind(":SA", $data['SA']);
                $this->php_bind(":CN", $data['CN']);
                $this->php_bind(":email", $data['email']);
                $this->php_bind(":SQ", $data['SQ']);
                $this->php_bind(":secA", $data['secA']);
                $this->php_bind(":branch", $data['branch']);
                if ($this->php_exec()) {
                    echo $this->php_responses(
                        true,
                        "single",
                        (object)[0 => array("key" => "success_registration")]
                    );
                }
            }
        }
    }
    public function UserManagementController($data)
    {
        $serverHelper = new Server();
        $queryIndicator = new Queries();
        if ($serverHelper->POSTCHECKER()) {
            if ($this->php_prepare($queryIndicator->InsertUserReg("users", "addUserReg"))) {
                $this->php_bind(":fname", $data['fname']);
                $this->php_bind(":lname", $data['lname']);
                $this->php_bind(":uname", $data['username']);
                $this->php_bind(":pwd", $this->php_encrypt_password($data['pwd']));
                $this->php_bind(":uType", $data['uType']);
                $this->php_bind(":uStatus", '1');
                $this->php_bind(":imgURL", 'None');
                $this->php_bind(":PA", $data['PA']);
                $this->php_bind(":SA", $data['SA']);
                $this->php_bind(":CN", $data['CN']);
                $this->php_bind(":email", $data['email']);
                $this->php_bind(":SQ", $data['SQ']);
                $this->php_bind(":secA", $data['secA']);
                $this->php_bind(":branch", $data['branch']);
                if ($this->php_exec()) {
                    echo $this->php_responses(
                        true,
                        "single",
                        (object)[0 => array("key" => "user_registration")]
                    );
                }
            }
        }
    }

    public function IFetchController()
    {
        $serverHelper = new Server();
        $queryIndicator = new Queries();
        if ($serverHelper->POSTCHECKER()) {
            if ($this->php_query($queryIndicator->fetchAllQuestions("fetch/questions"))) {
                $this->php_exec();
                if ($this->php_row_checker()) {
                    $row = $this->php_fetchAll();
                    echo $this->php_responses(
                        true,
                        "single",
                        (object)[0 => array("key" => $row)]
                    );
                }
            }
        }
    }
    public function IFetchBranchController()
    {
        $serverHelper = new Server();
        $queryIndicator = new Queries();
        if ($serverHelper->POSTCHECKER()) {
            if ($this->php_query($queryIndicator->fetchAllBranch("fetch/branchName"))) {
                $this->php_exec();
                if ($this->php_row_checker()) {
                    $row = $this->php_fetchAll();
                    echo $this->php_responses(
                        true,
                        "single",
                        (object)[0 => array("key" => $row)]
                    );
                }
            }
        }
    }
}
