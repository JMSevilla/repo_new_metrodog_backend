<?php

include_once __DIR__ . "/db.php";
include_once __DIR__ . "/queries.php";

interface IScanner
{
    public function GETPLATFORM($data);
}

class ScannerController extends DatabaseMigration implements IScanner
{
    public function GETPLATFORM($data)
    {
        $serverChecker = new Server();
        $QueryIdentifier = new Queries();
        if ($serverChecker->POSTCHECKER()) {
            if ($this->php_prepare($QueryIdentifier->getSavedPlatform('get/saved/platform'))) {
                $this->php_bind(':owner', $data['owner']);
                if ($this->php_exec()) {
                    if ($this->php_row_checker()) {
                        $get = $this->php_fetchRow();
                        if ($get['tokenSavedPlatform'] === 'admin_selection') {
                            echo $this->php_responses(
                                true,
                                "single",
                                (object)[0 => array("key" => "to_platform_adminselection")]
                            );
                        } else if ($get['tokenSavedPlatform'] === 'admin') {
                            echo $this->php_responses(
                                true,
                                "single",
                                (object)[0 => array("key" => "to_platform_admin")]
                            );
                        } else {
                            echo $this->php_responses(
                                true,
                                "single",
                                (object)[0 => array("key" => "to_home")]
                            );
                        }
                    }
                }
            }
        }
    }
}
