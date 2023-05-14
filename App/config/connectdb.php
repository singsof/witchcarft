<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');
// declare(strict_types=1);
require_once __DIR__ . "/config.inc.php";


class DB
{
    public static $link = null;
    private static function getLink()
    {
        if (self::$link) {
            return self::$link;
        }
        self::$link = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USERNAME, DB_PASSWORD);
        self::$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$link->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        return self::$link;
    }

    public static function __callStatic($name, $args)
    {
        $callback = array(self::getLink(), $name);
        return call_user_func_array($callback, $args);
    }
}


function uploadeImageBase64($data): stdClass
{
    $result = new stdClass();
    $result->name = generateRandomStringIM(2) . date("Y_m_d_H_i_s") . generateRandomStringIM(3) . generateRandomStringIM(3) . ".png";
    try {

        if (file_put_contents($data->path . $result->name, base64_decode($data->base64_code))) {
            $result->msg = "success";
            $result->msg_text = 'บันทึกรูปภาพสำเร็จ';
        } else {
            $result->msg = "error";
            $result->msg_text = 'กรุณาลองใหม่อีกครั้ง';
        }
    } catch (Exception $e) {
        $result->msg = "error";
        $result->msg_text = $e->getMessage();
    }

    return $result;
}


function OutputJson($data)
{
    header('Content-Type: application/json');
    $json = json_encode($data);
    // output JSON data
    echo $json;
}


function generateRandomString($length = 10)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateRandomStringIM($length = 10)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    try {
        $bytes = random_bytes($length);
        for ($i = 0; $i < $length; $i++) {
            $index = ord($bytes[$i]) % $charactersLength;
            $randomString .= $characters[$index];
        }
    } catch (Exception $e) {
        // handle the exception
    }
    return $randomString;
}


function check_Duplicate(string $sql_text, array $data = []): stdClass
{
    $resulte = new stdClass();

    unset($data['0']);

    try {
        $tem = DB::prepare($sql_text);
        $tem->execute($data);
        $count = (int) $tem->rowCount();

        $resulte->data = $tem->fetch(PDO::FETCH_OBJ);

        if ($count != 0) :
            $resulte->status = false;
            $resulte->status_code = 422;
            return $resulte;
        endif;

        $resulte->status = true;
        $resulte->status_code = 200;
        return $resulte;
    } catch (Exception $th) {
        $resulte->data = null;
        $resulte->status = false;
        $resulte->status_code = 500;
        return $resulte;
    }
}

function queryData($sqlText, $data = []): stdClass
{
    // str_replace("null", '-', $data, $i);
    $resulte = new stdClass();
    // unset($data['0']);
    try {
        $tem = DB::prepare($sqlText);
        $tem->execute($data);

        $resulte->data = $tem->fetchAll(PDO::FETCH_OBJ);
        $resulte->status = true;
        $resulte->status_code = 200;

        return $resulte;
    } catch (Exception $ex) {
        $resulte->data = $ex->getMessage();
        $resulte->status = false;
        $resulte->status_code = 500;
        return $resulte;
    }
}



class Database
{

    private $hostname = DB_HOST, $dbname = DB_NAME, $username =DB_USERNAME, $password = DB_PASSWORD;
    public $conn = null;

    function __construct()
    {

        try {

            $this->conn = new PDO("mysql:host= {$this->hostname};dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function customSelect($sql)
    {
        try {
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute();
            $rows = $stmt->fetchAll(); // assuming $result == true
            return $rows;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function select($tbl, $cond = '')
    {
        $sql = "SELECT * FROM $tbl";
        if ($cond != '') {
            $sql .= " WHERE $cond ";
        }

        try {
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute();
            $rows = $stmt->fetchAll(); // assuming $result == true
            return $rows;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    function num_rows($rows)
    {
        $n = count($rows);
        return $n;
    }

    function delete($tbl, $cond = '')
    {
        $sql = "DELETE FROM `$tbl`";
        if ($cond != '') {
            $sql .= " WHERE $cond ";
        }

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->rowCount(); // 1
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    function insert($tbl, $arr)
    {
        $sql = "INSERT INTO $tbl (`";
        $key = array_keys($arr);
        $val = array_values($arr);
        $sql .= implode("`, `", $key);
        $sql .= "`) VALUES ('";
        $sql .= implode("', '", $val);
        $sql .= "')";

        $sql1 = "SELECT MAX( id ) FROM  `$tbl`";
        try {

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $stmt2 = $this->conn->prepare($sql1);
            $stmt2->execute();
            $rows = $stmt2->fetchAll(); // assuming $result == true
            return $rows[0][0];
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    function update($tbl, $arr, $cond)
    {
        $sql = "UPDATE `$tbl` SET ";
        $fld = array();
        foreach ($arr as $k => $v) {
            $fld[] = "`$k` = '$v'";
        }
        $sql .= implode(", ", $fld);
        $sql .= " WHERE " . $cond;

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->rowCount(); // 1
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
