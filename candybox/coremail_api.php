<?php

function ary2String($ary) {
    $s = "";
    foreach ($ary as $key => $val) {
        if ($s != "")
            $s .= "&";
        $s .= urlencode($key) . "=" . urlencode($val);
    }
    return $s;
}

function string2Ary($s) {
    parse_str($s, $res);
    return $res;
}

function getIfSet(& $var) {
    if (isset($var)) {
        return $var;
    }
    return "";
}

class CoremailAPI {

    function CoremailAPI() {
        $this->socket = false;
    }

    function getErrorCode() {
        return $this->errCode;
    }

    function getErrorString() {
        return $this->errString;
    }

    function getResult() {
        return $this->result;
    }

    function close() {
        if ($this->socket) {
            fclose($this->socket);
            $this->socket = false;
        }
        $this->errCode = 0;
        $this->errString = "";
        $this->result = "";
    }

    function open($host, $port = 6195, $timeout = 10) {
        if ($this->socket)
            $this->close();
        if (false == ($this->socket = fsockopen($host, $port, $this->errCode, $this->errString, $timeout) ))
            return false;
        stream_set_timeout($this->socket, $timeout);
        return true;
    }

    function setTimeout($timeout) {
        stream_set_timeout($this->socket, $timeout);
    }

    function call($strArgs, $strAttrs) {
        if (is_array($strArgs))
            $ar = $strArgs;
        else {
            parse_str($strArgs, $ar);
            foreach ($ar as $key => $val) {
                if (in_array($key, $this->aryInt))
                    $ar[$key] = intval($val);
            }
        }
        if (!is_null($strAttrs))
            $ar["attrs"] = $strAttrs;
        return $this->cmd($ar);
    }

    /////////////////////////////////////////////////////////////////////////////////

    function addUser($strOrgID, $strUserAtDomain, $params) {
        return $this->cmd(array(
                    "cmd" => 0,
                    "org_id" => $strOrgID,
                    "user_at_domain" => $strUserAtDomain,
                    "attrs" => $strParams
        ));
    }

    function delUser($strUserAtDomain) {
        return $this->cmd(array(
                    "cmd" => 2,
                    "user_at_domain" => $strUserAtDomain
        ));
    }

    function alterUserInfo($strUserAtDomain, $params) {
        return $this->cmd(array(
                    "cmd" => 1,
                    "user_at_domain" => $strUserAtDomain,
                    "attrs" => $strParams
        ));
    }

    function getUserInfo($strUserAtDomain, $params) {
        return $this->cmd(array(
                    "cmd" => 3,
                    "user_at_domain" => $strUserAtDomain,
                    "attrs" => $strParams
        ));
    }

    function userLogin($strUserAtDomain, $strParams) {
        return $this->cmd(array(
                    "cmd" => 5,
                    "user_at_domain" => $strUserAtDomain,
                    "attrs" => $strParams
        ));
    }

    function userLogout($strSessionID) {
        return $this->cmd(array(
                    "cmd" => 6,
                    "ses_id" => $strSessionID
        ));
    }

    function hasUser($strUserAtDomain) {
        return $this->cmd(array(
                    "cmd" => 4,
                    "user_at_domain" => $strUserAtDomain
        ));
    }

    function setTempVar($strSessionID, $strParams) {
        return $this->cmd(array(
                    "cmd" => 7,
                    "ses_id" => $strSessionID,
                    "ses_key" => "TempVar",
                    "ses_var" => $strParams
        ));
    }

    function getTempVar($strSessionID) {
        return $this->cmd(array(
                    "cmd" => 8,
                    "ses_id" => $strSessionID,
                    "ses_key" => "TempVar"
        ));
    }

    function checkSesTimeout($strSessionID) {
        return $this->cmd(array(
                    "cmd" => 9,
                    "ses_id" => $strSessionID
        ));
    }

    function checkPass($strUserAtDomain, $strPass) {
        return $this->cmd(array(
                    "cmd" => 12,
                    "user_at_domain" => $strUserAtDomain,
                    "password" => $strPass
        ));
    }

    function refreshSes($strSessionID) {
        return $this->cmd(array(
                    "cmd" => 10,
                    "ses_id" => $strSessionID
        ));
    }

    /////////////////////////////////////////////////////////////////////////////////

    function getExtUserInfo($strUserAtDomain, $params) {
        return $this->cmd(array(
                    "cmd" => 37,
                    "user_at_domain" => $strUserAtDomain,
                    "attrs" => $strParams
        ));
    }

    function getAdminType($strUserAtDomain) {
        return $this->cmd(array(
                    "cmd" => 36,
                    "user_at_domain" => $strUserAtDomain
        ));
    }

    function getSessionVar($strSessionID, $strKey) {
        return $this->cmd(array(
                    "cmd" => 8,
                    "ses_id" => $strSessionID,
                    "ses_key" => $strKey
        ));
    }

    function addDomain($strDomain) {
        return $this->cmd(array(
                    "cmd" => 31,
                    "domain_name" => $strDomain
        ));
    }

    function addDomainAlias($strDomain, $strDomainAlias) {
        return $this->cmd(array(
                    "cmd" => 32,
                    "domain_name" => $strDomain,
                    "domain_name_alias" => $strDomainAlias
        ));
    }

    function listDomainAlias($strDomain) {
        return $this->cmd(array(
                    "cmd" => 34,
                    "domain_name" => $strDomain
        ));
    }

    function delDomainAlias($strDomain, $strDomainAlias) {
        return $this->cmd(array(
                    "cmd" => 33,
                    "domain_name" => $strDomain,
                    "domain_name_alias" => $strDomainAlias
        ));
    }

    function delDomain($strDomain) {
        return $this->cmd(array(
                    "cmd" => 35,
                    "domain_name" => $strDomain
        ));
    }

    function domainExist($strDomain) {
        return $this->cmd(array(
                    "cmd" => 49,
                    "domain_name" => $strDomain
        ));
    }

    function listDomain() {
        return $this->cmd(array(
                    "cmd" => 51
        ));
    }

    function getOrgByDomain($strDomain) {
        return $this->cmd(array(
                    "cmd" => 50,
                    "domain_name" => $strDomain
        ));
    }

    function addFilter($strUserAtDomain, $strFilter) {
        return $this->cmd(array(
                    "cmd" => 18,
                    "user_at_domain" => $strUserAtDomain,
                    "attrs" => $strFilter
        ));
    }

    function removeFilter($strUserAtDomain, $strFilterName) {
        return $this->cmd(array(
                    "cmd" => 19,
                    "user_at_domain" => $strUserAtDomain,
                    "attrs" => $strFilterName
        ));
    }

    function addOrg($strOrgID, $strParams) {
        return $this->cmd(array(
                    "cmd" => 22,
                    "org_id" => $strOrgID,
                    "attrs" => $strParams
        ));
    }

    function addOrgCos($strOrgID, $nCosID, $nNumOfClass) {
        return $this->cmd(array(
                    "cmd" => 28,
                    "org_id" => $strOrgID,
                    "cos_id" => $nCosID,
                    "num_of_classes" => $nNumOfClass
        ));
    }

    function alterOrgCos($strOrgID, $nCosID, $nNumOfClass) {
        return $this->cmd(array(
                    "cmd" => 29,
                    "org_id" => $strOrgID,
                    "cos_id" => $nCosID,
                    "num_of_classes" => $nNumOfClass
        ));
    }

    function delOrgCos($strOrgID, $nCosID) {
        return $this->cmd(array(
                    "cmd" => 30,
                    "org_id" => $strOrgID,
                    "cos_id" => $nCosID
        ));
    }

    function getOrgInfo($strOrgID, $strParams) {
        return $this->cmd(array(
                    "cmd" => 24,
                    "org_id" => $strOrgID,
                    "attrs" => $strParams
        ));
    }

    function alterOrg($strOrgID, $strParams) {
        return $this->cmd(array(
                    "cmd" => 23,
                    "org_id" => $strOrgID,
                    "attrs" => $strParams
        ));
    }

    function listOrgCosUser($strOrgID, $nCosID) {
        return $this->cmd(array(
                    "cmd" => 42,
                    "org_id" => $strOrgID,
                    "cos_id" => $nCosID
        ));
    }

    function getOrgCosUserMax($strOrgID, $nCosID) {
        return $this->cmd(array(
                    "cmd" => 44,
                    "org_id" => $strOrgID,
                    "cos_id" => $nCosID
        ));
    }

    function listOrg() {
        return $this->cmd(array(
                    "cmd" => 43
        ));
    }

    function addAllowedDomain($strOrgID, $strDomain) {
        return $this->cmd(array(
                    "cmd" => 26,
                    "org_id" => $strOrgID,
                    "domain_name" => $strDomain
        ));
    }

    function delAllowedDomain($strOrgID, $strDomain) {
        return $this->cmd(array(
                    "cmd" => 27,
                    "org_id" => $strOrgID,
                    "domain_name" => $strDomain
        ));
    }

    function addSmtpAlias($strUserAtDomain, $strUserAtDomainAlias) {
        return $this->cmd(array(
                    "cmd" => 45,
                    "user_at_domain" => $strUserAtDomain,
                    "alias_user_at_domain" => $strUserAtDomainAlias
        ));
    }

    function delSmtpAlias($strUserAtDomain, $strUserAtDomainAlias) {
        return $this->cmd(array(
                    "cmd" => 46,
                    "user_at_domain" => $strUserAtDomain,
                    "alias_user_at_domain" => $strUserAtDomainAlias
        ));
    }

    function listSmtpAlias($strUserAtDomain) {
        return $this->cmd(array(
                    "cmd" => 47,
                    "user_at_domain" => $strUserAtDomain
        ));
    }

    function setFolderByName($strUserAtDomain, $folder, $params) {
        return $this->cmd(array(
                    "cmd" => 63,
                    "user_at_domain" => $strUserAtDomain,
                    "name" => $folder,
                    "attrs" => $strParams
        ));
    }

    function setFolderByFolderID($strUserAtDomain, $folderID, $params) {
        return $this->cmd(array(
                    "cmd" => 63,
                    "user_at_domain" => $strUserAtDomain,
                    "fid" => $folderID,
                    "attrs" => $strParams
        ));
    }

    function delFolderByName($strUserAtDomain, $folder) {
        return $this->cmd(array(
                    "cmd" => 64,
                    "user_at_domain" => $strUserAtDomain,
                    "name" => $folder
        ));
    }

    function delFolderByFolderID($strUserAtDomain, $folderID) {
        return $this->cmd(array(
                    "cmd" => 64,
                    "user_at_domain" => $strUserAtDomain,
                    "fid" => $folderID
        ));
    }

    /////////////////////////////////////////////////////////////////////////////////

    function setAdminType($strUserAtDomain) {
        return $this->cmd(array(
                    "cmd" => 40,
                    "user_at_domain" => $strUserAtDomain
        ));
    }

    function checkUserIsProxyState($strUserAtDomain) {
        return $this->cmd(array(
                    "cmd" => 41,
                    "user_at_domain" => $strUserAtDomain
        ));
    }

    function getOuName($strOrgID, $strOUID) {
        return $this->cmd(array(
                    "cmd" => 53,
                    "org_id" => $strOrgID,
                    "org_unit_id" => $strOUID
        ));
    }

    function getOuHiberarchy($strOrgID, $strOUID) {
        return $this->cmd(array(
                    "cmd" => 54,
                    "org_id" => $strOrgID,
                    "org_unit_id" => $strOUID
        ));
    }

    function getOuHiberarchyByUser($strUserAtDomain) {
        return $this->cmd(array(
                    "cmd" => 55,
                    "user_at_domain" => $strUserAtDomain
        ));
    }

    function setSessionVar($strSessionID, $strSesKey, $strSesVal) {
        return $this->cmd(array(
                    "cmd" => 7,
                    "ses_id" => $strSessionID,
                    "ses_key" => $strSesKey,
                    "ses_var" => $strSesVal
        ));
    }

    function userRename($strUserAtDomain, $strNewName) {
        return $this->cmd(array(
                    "cmd" => 58,
                    "user_at_domain" => $strUserAtDomain,
                    "new_user_id" => $strNewName
        ));
    }

    /////////////////////////////////////////////////////////////////////////////////

    function cmd($cmd) {
        $this->result = "";
        $this->errCode = 0;
        $this->errString = "";
        $sendCmd = $this->pri_encode($cmd);

        if (!$this->socket) {
            $this->errCode = 1;
            $this->errString = "not connect";
            return false;
        } else if (false == fwrite($this->socket, pack("N", strlen($sendCmd)) . $sendCmd)) {
            $this->errCode = 3;
            $this->errString = "write error";
            return false;
        }
        $l = fread($this->socket, 4);
        if (strlen($l) != 4) {
            $this->errCode = 4;
            $this->errString = "read error";
            return false;
        }
        $bytes = unpack("N", $l);
        $res = fread($this->socket, $bytes[1]);
        if (strlen($res) != $bytes[1]) {
            $this->errCode = 4;
            $this->errString = "read content error";
            return false;
        }
        $ary = $this->pri_decode($res);
        if (!$ary)
            return false;
        $this->errCode = getIfSet($ary["retcode"]);
        $this->errString = getIfSet($ary["errmsg"]);
        $this->result = getIfSet($ary["result"]);
        return true;
    }

    function pri_saveString($s) {
        return pack("N", strlen($s) + 1) . $s . pack('C', 0);
    }

    function pri_saveArray($var) {
        $res = pack("N", count($var));
        foreach ($var as $key => $val) {
            if (is_int($val))
                $res .= $this->pri_saveString($key) . pack("NN", 0x01, $val);
            else if (is_string($val))
                $res .= $this->pri_saveString($key) . pack("N", 0x02) . $this->pri_saveString($val);
            else if (is_array($val))
                $res .= $this->pri_saveString($key) . pack("N", 0x02) . $this->pri_saveString(ary2String($val));
        }
        return $res;
    }

    function pri_encode($var) {
        if (!is_array($var))
            return false;
        return pack("NnnC", 0xffffffff, 0x01, 0x01, 0x00) . $this->pri_saveArray($var);
    }

    function pri_getString($res, &$off) {
        $l = unpack("N", substr($res, $off));
        $off += 4;
        $s = substr($res, $off, $l[1] - 1);
        $off += $l[1];
        return $s;
    }

    function pri_getArray($res, &$off) {
        $ary = array();
        $ca = unpack("N", substr($res, $off));
        $off += 4;
        $c = $ca[1];
        for ($i = 0; $i < $c; ++$i) {
            $key = $this->pri_getString($res, $off);
            $ta = unpack("N", substr($res, $off));
            $off += 4;
            $t = $ta[1];
            if ($t == 0x01) {
                $ta = unpack("N", substr($res, $off));
                $off += 4;
                $ary[$key] = $ta[1];
            } else if ($t == 0x02) {
                $ary[$key] = $this->pri_getString($res, $off);
            }
        }
        return $ary;
    }

    function pri_decode($res) {
        $header = unpack("Na/nb/nc", $res);
        if (($header["a"] != 0xffffffff && $header["a"] != -1) || $header["b"] != 0x01 || $header["c"] != 0x01)
            return false;
        $off = 9;
        return $this->pri_getArray($res, $off);
    }

    var $socket;
    var $errCode;
    var $errString;
    var $result;
    var $aryInt = array("cmd", "cos_id", "num_of_classes", "limit", "skip");

}

;

function testCoremailAPI() {
    $api = new CoremailAPI;
    if (!$api->open("192.168.170.4")) {
        echo($api->getErrorCode() . " : " . $api->getErrorString() . "\n");
    } else if (!$api->userLogin("admin@develop.com", array("style" => "1", "language" => "2")) || $api->getErrorCode()) {
        echo("Login fail : " . $api->getErrorCode() . " : " . $api->getErrorString() . "\n");
    } else {
        echo("Login ok: " . $api->getResult() . "\n");
    }
    $api->close();
}

function testCoremailAPICommentCall() {
    $api = new CoremailAPI;
    if (!$api->open("192.168.170.4")) {
        echo($api->getErrorCode() . " : " . $api->getErrorString() . "\n");
    } else if (!$api->call("cmd=5&user_at_domain=admin@develop.com", array("style" => "1", "language" => "2")) || $api->getErrorCode()) {
        echo("Login fail : " . $api->getErrorCode() . " : " . $api->getErrorString() . "\n");
    } else {
        echo("Login ok: " . $api->getResult() . "\n");
    }
    $api->close();
}