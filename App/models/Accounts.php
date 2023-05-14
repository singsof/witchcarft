<?php

use Leaf\Form;

require_once __DIR__ . '/../config/connectdb.php';

class Accounts
{
    # code...
    private  $account_id = null;
    private  $account_name  = null;
    private  $account_password  = null;
    private  $account_email  = null;
    private  $account_phone  = null;
    private  $account_address  = null;
    private  $create_date  = null;
    private  $account_status = 'show';
    private  $account_role = 'user';
    public $response = null;




    public function getShowAccountsAll($ATTR_DEFAULT = PDO::FETCH_OBJ)
    { // return OBJ 
        $result = new stdClass();
        $this->account_status = $this->account_status ?? 'show';

        try {


            $qurey = DB::query("SELECT * FROM `accounts` WHERE account_status = '{$this->account_status}'", $ATTR_DEFAULT)->fetchAll($ATTR_DEFAULT); // false
            if (!$qurey) {
                $result->status = 'success';
                $result->msg = 'ไม่พบข้อมูล';
                return null;
            }
            $result->status = 'success';
            $result->msg = 'ดึงข้อมูลสำเร็จ';
            $this->response = $result;

            return $qurey;
        } catch (Exception $e) {

            $result->status = 'error';
            $result->msg = 'error! :   => ' . $e->getMessage();
            $this->response = $result;

            return null;
        }
    }

    public function getShowAccountsOne($key, $ATTR_DEFAULT = PDO::FETCH_OBJ)
    {
        $key = Form::sanitizeInput($key);
        $result = new stdClass();

        try {
            $sql = sprintf("SELECT * FROM `accounts` WHERE %s = '%s'", is_numeric($key) ? 'account_id' : 'account_email', $key);

            $result->status = 'success';
            $result->msg = 'ดึงข้อมูล ' . sprintf(" %s = '%s'", is_numeric($key) ? 'account_id' : 'account_email', $key) . ' สำเร็จ';

            $this->response = $result;

            $stmt = DB::query($sql, $ATTR_DEFAULT)->fetch($ATTR_DEFAULT);

            $this->account_id = $stmt->account_id;
            $this->account_name  = $stmt->account_name;
            $this->account_email  = $stmt->account_email;
            $this->account_phone  = $stmt->account_phone;
            $this->account_address  = $stmt->account_address;
            $this->account_password  = $stmt->account_password;
            $this->create_date  = $stmt->create_date;
            $this->account_status = $stmt->account_status;
            $this->account_role = $stmt->account_role;

            return $stmt;
        } catch (Exception $e) {
            return null;
        }
    }


    private function getPrivateAccountsOne($key, $ATTR_DEFAULT = PDO::FETCH_OBJ)
    {
        $key = Form::sanitizeInput($key);
        $result = new stdClass();

        try {
            $sql = sprintf("SELECT * FROM `accounts` WHERE %s = '%s'", is_numeric($key) ? 'account_id' : 'account_email', $key);

            $result->status = 'success';
            $result->msg = 'ดึงข้อมูล ' . sprintf(" %s = '%s'", is_numeric($key) ? 'account_id' : 'account_email', $key) . ' สำเร็จ';

            $this->response = $result;

            $stmt = DB::query($sql, $ATTR_DEFAULT)->fetch($ATTR_DEFAULT);


            return $stmt;
        } catch (Exception $e) {
            return null;
        }
    }

    public function insertAccounts(): bool //เพิ่ม
    {

        $result = new stdClass();
        $resultAccounts = $this->getShowAccountsAll(PDO::FETCH_ASSOC) ?? [];

        $isCheckAccount_name = $this->account_name ?? false;
        $isCheckAccount_password = $this->account_password ?? false;
        $isCheckAccount_email = $this->account_email ?? false;
        $isCheckAccount_phone = $this->account_phone ?? false;
        $isCheckAccount_address = $this->account_address ?? false;

        if (!$isCheckAccount_name || !$isCheckAccount_phone || !$isCheckAccount_address || !$isCheckAccount_password || !$isCheckAccount_email) {
            $result->status = 'error';
            $result->msg = 'กรุณากรอกข้อมูลให้ครบถ้วน!';
            $this->response = $result;
            return false;
        }

        $issetEmailInData  = array_reduce(array_filter(
            $resultAccounts,
            function ($account) {
                return $account['account_email'] === $this->account_email;
            }
        ), function () {
            return false;
        }, true);


        if (!$issetEmailInData) {
            $result->status = 'error';
            $result->msg = 'Email นี้เคยใช้สมัครแล้ว';
            $this->response = $result;
            return false;
        }


        try {

            DB::query(
                "INSERT INTO `accounts` (`account_id`, `account_name`, `account_password`, `account_email`, `account_phone`, `account_address`, `create_date`, `account_status`, `account_role`) 
                VALUES (NULL, '{$this->account_name}', '{$this->account_password}', '{$this->account_email}', '{$this->account_phone}', '{$this->account_address}', current_timestamp(), '{$this->account_status}', '{$this->account_role}');"
            );

            $result->status = 'success';
            $result->msg = 'เพิ่มข้อมูลสำเร็จ!.....';

            $this->response = $result;
            return true;
        } catch (Exception $e) {
            $result->status = 'error';
            $result->msg = 'error! :  ' . $e->getMessage();
            $this->response = $result;
            return false;
        }
    }
    public function updateAccounts(): bool
    {
        $result = new stdClass();

        if ($this->account_id === null || $this->account_id === '') {
            $result->status = 'error';
            $result->msg = 'กรุณาระบุ แอคเคาท์ไอดี ให้ถูกต้อง ';
            $this->response = $result;
            return false;
        }

        $accountResult = $this->getPrivateAccountsOne($this->account_id);

        
        $this->account_id = $this->account_id ?? $accountResult->account_id;
        $this->account_name = $this->account_name ?? $accountResult->account_name;
        $this->account_password = $this->account_password ?? $accountResult->account_password;
        $this->account_email = $this->account_email ?? $accountResult->account_email;
        $this->account_phone = $this->account_phone ?? $accountResult->account_phone;
        $this->account_address = $this->account_address ?? $accountResult->account_address;
        $this->account_status = $this->account_status != 'show' ? $this->account_status : 'show';
        $this->account_role = $this->account_role != 'user' ? $this->account_role : 'user';

        

        $getShowAccountsAll = $this->getShowAccountsAll(PDO::FETCH_ASSOC);
        $filterData  = array_filter(
            $getShowAccountsAll,
            function ($var) use ($accountResult) {
                return $var['account_email'] !== $accountResult->account_email;
            }
        );

        $isCheckDataAllow  = array_reduce(array_filter(
            $filterData,
            function ($account) {
                return $account['account_email'] === $this->account_email;
            }
        ), function () {
            return false;
        }, true);


        if (!$isCheckDataAllow) {
            $result->status = 'error';
            $result->msg = 'ไม่สามารถใช้อีเมลนี้ได้';
            $this->response = $result;
            return false;
        }


        try {

            DB::query(
                "UPDATE `accounts` SET `account_name` = '{$this->account_name}', 
                                    `account_password` = '{$this->account_password}', 
                                    `account_email` = '{$this->account_email}', 
                                    `account_phone` = '{$this->account_phone}', 
                                    `account_address` = '{$this->account_address}', 
                                    `account_status` = '{$this->account_status}',
                                    `account_role` = '{$this->account_role}'
                                    WHERE `accounts`.`account_id` = {$this->account_id};"
            );

            $result->status = 'success';
            $result->msg = 'แก้ไขข้อมูลสำเร็จ!.....';

            $this->response = $result;
            return true;
        } catch (Exception $e) {
            $result->status = 'error';
            $result->msg = 'แก้ไขข้อมูลไม่สำเร็จ! : ' . $e->getMessage();
            $this->response = $result;
            return false;
        }
    }

    public function deleteAccount()
    {
        $result = new stdClass();

        if ($this->account_id === null || $this->account_id === '') {
            $result->status = 'error';
            $result->msg = 'กรุณาระบุ แอคเคาท์ไอดี ให้ถูกต้อง ';
            $this->response = $result;
            return false;
        }
        $this->account_status =  'delete';
        try {

            DB::query(
                "UPDATE `accounts` SET  `account_status` = '{$this->account_status}' WHERE `accounts`.`account_id` = {$this->account_id};"
            );

            $result->status = 'success';
            $result->msg = 'ลบข้อมูลสำเร็จ!.....';

            $this->response = $result;
            return true;
        } catch (Exception $e) {
            $result->status = 'error';
            $result->msg = 'ลบข้อมูลไม่สำเร็จ! : ' . $e->getMessage();
            $this->response = $result;
            return false;
        }
    }

    public function verifyAccount_password($hashedPassword): bool
    {
        return password_verify($this->account_password, $hashedPassword);
    }
    public function verifyAccountLogin(): bool
    {
        $result = new stdClass();

        $isCheckPassword = $this->account_password ?? false;
        $isCheckEmail = $this->account_email ?? false;

        if (!$isCheckPassword || !$isCheckEmail) {
            $result->status = 'error';
            $result->msg = 'กรุณากรอกข้อมูลให้ครบถ้วน';
            $this->response = $result;
            return false;
        }

        $resultAccount = $this->getPrivateAccountsOne($this->account_email, PDO::FETCH_OBJ);

        if (!$resultAccount) {
            $result->status = 'error';
            $result->msg = 'กรุณาตรวจสอบรหัสผ่าน!';
            $this->response = $result;
            return false;
        }

        if ($this->verifyAccount_password($resultAccount->account_password)) {
            $result->status = 'success';
            $result->msg = 'เข้าสู่ระบบสำเร็จ......';
            $this->response = $resultAccount;
            return true;
        }
        // $this->response = $this->verifyAccount_password($resultAccount->account_password);

        // return false;

        $result->status = 'error';
        $result->msg = 'กรุณาตรวจสอบรหัสผ่าน!';
        $this->response = $result;
        return false;
    }

    /**
     * Get the value of account_id
     */
    public function getAccount_id()
    {
        return $this->account_id;
    }

    /**
     * Set the value of account_id
     *
     * @return  self
     */
    public function setAccount_id($account_id)
    {

        $this->account_id = Form::sanitizeInput($account_id);

        return $this;
    }

    /**
     * Get the value of account_name
     */
    public function getAccount_name()
    {
        return $this->account_name;
    }

    /**
     * Set the value of account_name
     *
     * @return  self
     */
    public function setAccount_name($account_name)
    {
        $this->account_name = Form::sanitizeInput($account_name);

        return $this;
    }

    /**
     * Get the value of account_password
     */
    public function getAccount_password()
    {
        return $this->account_password;
    }

    /**
     * Set the value of account_password
     *
     * @return  self
     */
    public function setAccount_password($account_password, $hash = false)
    {
        $account_password = Form::sanitizeInput($account_password);
        if (!$hash) {
            $this->account_password = password_hash($account_password, PASSWORD_DEFAULT);
        } else {
            $this->account_password = $account_password;
        }

        return $this;
    }

    public function setAccount_passwordNoHash($account_password)
    {
        $this->account_password = $account_password;
        return $this;
    }

    /**
     * Get the value of account_email
     */
    public function getAccount_email()
    {
        return $this->account_email;
    }

    /**
     * Set the value of account_email
     *
     * @return  self
     */
    public function setAccount_email($account_email)
    {
        $this->account_email = Form::sanitizeInput($account_email);

        return $this;
    }

    /**
     * Get the value of account_phone
     */
    public function getAccount_phone()
    {
        return $this->account_phone;
    }

    /**
     * Set the value of account_phone
     *
     * @return  self
     */
    public function setAccount_phone($account_phone)
    {
        $this->account_phone = Form::sanitizeInput($account_phone);

        return $this;
    }

    /**
     * Get the value of account_address
     */
    public function getAccount_address()
    {
        return $this->account_address;
    }

    /**
     * Set the value of account_address
     *
     * @return  self
     */
    public function setAccount_address($account_address)
    {
        $this->account_address = Form::sanitizeInput($account_address);

        return $this;
    }

    /**
     * Get the value of create_date
     */
    public function getCreate_date()
    {
        return $this->create_date;
    }

    /**
     * Set the value of create_date
     *
     * @return  self
     */
    public function setCreate_date($create_date)
    {
        $this->create_date = Form::sanitizeInput($create_date);

        return $this;
    }

    /**
     * Get the value of account_status
     */
    public function getAccount_status()
    {
        return $this->account_status;
    }

    /**
     * Set the value of account_status
     *
     * @return  self
     */
    public function setAccount_status($account_status = 'show')
    {
        $this->account_status = Form::sanitizeInput($account_status);

        return $this;
    }

    /**
     * Get the value of account_role
     */
    public function getAccount_role()
    {
        return $this->account_role;
    }

    /**
     * Set the value of account_role
     *
     * @return  self
     */
    public function setAccount_role($account_role = 'user')
    {
        $this->account_role = Form::sanitizeInput($account_role);

        return $this;
    }
}
