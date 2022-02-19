<?php
include_once __DIR__ . "/db.php";
include_once __DIR__ . "/queries.php";

interface ICookie
{
    public function cookieSetter(
        $tokenRequest,
        $tokenTimeStamp,
        $tokenPath,
        $isSecure,
        $isHttp,
        $isSameSite,
        $tokenName
    );
    public function tokenIsset($token_data);
    public function tokenUnset($token_name);
}

class TokenParams
{
    public static $tokenInitialize = null;
}

class CookieManagement implements ICookie
{
    public function cookieSetter(
        $tokenRequest,
        $tokenTimeStamp,
        $tokenPath = null,
        $isSecure = false,
        $isHttp = false,
        $isSameSite = 'None',
        $tokenName
    ) {
        TokenParams::$tokenInitialize = array(
            'expires' => $tokenTimeStamp,
            'path' => $tokenPath,
            'secure' => $isSecure,
            'httponly' => $isHttp,
            'samesite' => $isSameSite
        );
        setcookie($tokenName, $tokenRequest, TokenParams::$tokenInitialize);
    }
    public function tokenIsset($token_data)
    {
        return isset($_COOKIE[$token_data]);
    }
    public function tokenUnset($token_name)
    {
        if (isset($_COOKIE[$token_name])) {
            unset($_COOKIE[$token_name]);
            setcookie($token_name, null, -1, '/');
            return true;
        } else {
            return false;
        }
    }
}


interface IScanCookie
{
    public function cookieScanner($args);
}
class ScanCookie extends DatabaseMigration implements IScanCookie
{
    public function cookieScanner($args)
    {
        $cookieHandler = new CookieManagement();
        $queryIndicator = new Queries();
        $serverHelper = new Server();
        if ($serverHelper->POSTCHECKER()) {
            if ($this->php_prepare($queryIndicator->scanToken("scan/token"))) {
                $this->php_bind(":owner", $args);
                if ($this->php_exec()) {
                    if ($this->php_row_checker()) {
                        // exist
                        $get = $this->php_fetchRow();
                        $savedId = $get['tokenOwnerId'];
                        if ($this->php_prepare($queryIndicator->getUserById("scan/token/getById"))) {
                            $this->php_bind(":uid", $savedId);
                            $this->php_exec();
                            if ($this->php_row_checker()) {
                                $row = $this->php_fetchRow();
                                if ($row['userStatus'] === "1") {
                                    //activated
                                    if ($row['userType'] === "1") {
                                        //admin
                                        if ($cookieHandler->tokenIsset('adminToken')) {
                                            if ($this->php_prepare($queryIndicator->getSavedPlatform("get/saved/platform"))) {
                                                $this->php_bind(":owner", $args);
                                                if ($this->php_exec()) {
                                                    $get = $this->php_fetchRow();
                                                    $savedplatform = $get['tokenSavedPlatform'];
                                                    if ($savedplatform === "admin") {
                                                        echo $this->php_responses(
                                                            true,
                                                            "single",
                                                            (object)[0 => array("key" => "cookie_admin_exist_platform_admin")]
                                                        );
                                                    } else {
                                                        echo $this->php_responses(
                                                            true,
                                                            "single",
                                                            (object)[0 => array("key" => "cookie_admin_exist_platform_admin_selection")]
                                                        );
                                                    }
                                                }
                                            }
                                        } else {
                                            echo $this->php_responses(
                                                true,
                                                "single",
                                                (object)[0 => array("key" => "cookie_admin_not_exist")]
                                            );
                                        }
                                    } else {
                                        //cashier
                                    }
                                } else {
                                    //account deactivated
                                    echo $this->php_responses(
                                        true,
                                        "single",
                                        (object)[0 => array("key" => "cookie_invalid")]
                                    );
                                }
                            }
                        }
                    } else {
                        //not exist
                        echo $this->php_responses(
                            true,
                            "single",
                            (object)[0 => array("key" => "cookie_invalid")]
                        );
                    }
                }
            } else {
            }
        }
    }
}
if (isset($_POST['scanCookie']) == true) {

    $arguement = new ScanCookie();
    $arguement->cookieScanner($_POST['tokenName']);
}
