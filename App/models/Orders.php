<?php

use Leaf\Form;

class Orders   {

    private $order_key   = null;
    private $order_code   = null;
    private $account_key   = null ;
    private $order_price   = null;
    private $order_delivery  = null ;
    private $order_price_delivery = null ;
    private $order_date = null;
    private $order_status = null;
    private $Tables = 'orders';
    public $response = null;

    public function __construct(){
    }


    public function getShowOrdersAll($ATTR_DEFAULT = PDO::FETCH_OBJ)
    { // return OBJ 
        $result = new stdClass();
        $this->order_status = $this->order_status ?? 'wait';

        try {

            $qurey = DB::query("SELECT * FROM  `Orders` WHERE order_status = '{$this->order_status}'", $ATTR_DEFAULT)->fetchAll($ATTR_DEFAULT); // false
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
            $result->msg = 'error : ' . $e->getMessage();
            $this->response = $result;

            return null;
        }
    }

    public function getShowOrdersOne($key, $ATTR_DEFAULT = PDO::FETCH_OBJ)
    {
        $key = Form::sanitizeInput($key  );
        $result = new stdClass();

        try {
            $sql = sprintf("SELECT * FROM `Orders` WHERE order_key = '%s';", $key);
            $result->status = 'success';
            $result->msg = 'ดึงข้อมูล สำเร็จ';

            $this->response = $result;
            return DB::query($sql, $ATTR_DEFAULT)->fetch($ATTR_DEFAULT);
        } catch (Exception $e) {
            return null;
        }
    }
    function getSelectOrders($cond = null, $ATTR_DEFAULT = PDO::FETCH_OBJ)
    {
        $response = new stdClass();
        $sql = "SELECT * FROM ".$this->Tables. ' ';
        if ($cond !== null) {
            $sql .= " WHERE $cond ";
        }

        try {
            // $stmt = DB::prepare($sql);
            // $stmt->execute();
            // $rows = $stmt->fetchAll($ATTR_DEFAULT); // assuming $result == true
            return DB::query($sql, $ATTR_DEFAULT)->fetchAll($ATTR_DEFAULT);
        } catch (PDOException $e) {
            $response->status = 'error';
            $response->msg = 'error!'.$e->getMessage();
            $this->response = $response;
            return null;
        }
    }

    public function getShowOrdersAllKey($key = null, $valueID, $ATTR_DEFAULT = PDO::FETCH_OBJ)
    {
        $key = Form::sanitizeInput($key ?? 'account_key' );
        $valueID = Form::sanitizeInput($valueID);

        $result = new stdClass();

        try {
            $sql = sprintf("SELECT * FROM `Orders` WHERE {$key} = '{$valueID}';");

            $result->status = 'success';
            $result->msg = 'ดึงข้อมูล สำเร็จ';

            $this->response = $result;
            return DB::query($sql, $ATTR_DEFAULT)->fetchAll($ATTR_DEFAULT);
        } catch (Exception $e) {
            return null;
        }
    }
    public function insertOrders() //เพิ่ม
    {

        $result = new stdClass();
        $this->order_status = $this->order_status ?? 'wait';

        $order_code = $this->order_code ?? false;
        $order_price = $this->order_price ?? false;
        $account_key = $this->account_key ?? false;
        $order_delivery = $this->order_delivery ?? false;
        $order_price_delivery = $this->order_price_delivery ?? false;

// INSERT INTO `orders` (`order_key`, `order_code`, `account_key`, `order_price`, `order_delivery`, `order_price_delivery`, `order_date`, `order_status`) VALUES (NULL, '324dsdfsdf', '24', '2333', 'ที่อยู่', '80', current_timestamp(), 'wait');
        if (!$order_code  || !$order_price || !$account_key || !$order_delivery || !$order_price_delivery ) {
            $result->status = 'error';
            $result->msg = 'กรุณากรอกข้อมูลให้ครบถ้วน!';
            $this->response = $result;
            return false;
        }


        try {

            $sql = sprintf(
                "INSERT INTO `orders` (`order_key`, `order_code`, `account_key`, `order_price`, `order_delivery`, `order_price_delivery`, `order_date`, `order_status`) 
                                VALUES (NULL, '%s', '%s', '%s', '%s', '%s', current_timestamp(), '%s');",
                $this->order_code,
                $this->account_key,
                $this->order_price,
                $this->order_delivery,
                $this->order_price_delivery,
                $this->order_status,
            );
            DB::query($sql);

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
    public function updateOrders()
    {

        $result = new stdClass();

        if ($this->order_key === null || $this->order_key === '') {
            $result->status = 'error';
            $result->msg = 'กรุณาระบุคีย์ ';
            $this->response = $result;
            return false;
        }

        $OrdersResult = $this->getShowOrdersOne($this->order_key);

        $this->order_code = $this->order_code ?? $OrdersResult->order_code;
        $this->account_key = $this->account_key ?? $OrdersResult->account_key;
        $this->order_price = $this->order_price ?? $OrdersResult->order_price;
        $this->order_delivery = $this->order_delivery ?? $OrdersResult->order_delivery;
        $this->order_price_delivery = $this->order_price_delivery ?? $OrdersResult->order_price_delivery;

        $this->order_status = $this->order_status ?? 'wait';


        // $OrdersResultALL = $this->getShowOrdersAll(PDO::FETCH_ASSOC);
        // $filterData  = array_filter(
        //     $OrdersResultALL,
        //     function ($var) use ($OrdersResult) {
        //         return ($var['order_code'] !== $OrdersResult->order_code && $var['order_price'] !== $OrdersResult->order_price);
        //     }
        // );

        // $isCheckDataAllow  = array_reduce(array_filter(
        //     $filterData,
        //     function ($var) {
        //         return $var['order_code'] === $this->order_code && $var['order_price'] === $this->order_price;
        //     }
        // ), function () {
        //     return false;
        // }, true);


        // if (!$isCheckDataAllow) {
        //     $result->status = 'error';
        //     $result->msg = 'ไม่สามารถใช้คีย์การ์ด หรือคีย์สินค้า นี้ได้';
        //     $this->response = $result;
        //     return false;
        // }

        try {

            $sql = sprintf(
                "UPDATE `Orders` SET 
                                    `order_code` = '%s', 
                                    `account_key` = '%s', 
                                    `order_price` = '%s', 
                                    `order_delivery` = '%s',
                                    `order_price_delivery` = '%s',
                                    `order_status` = '%s'
                                    WHERE `Orders`.`order_key` = '%s';",
                $this->order_code,
                $this->account_key,
                $this->order_price,
                $this->order_delivery,
                $this->order_price_delivery,
                $this->order_status,
                $this->order_key

            );
            DB::query($sql);

            $result->status = 'success';
            $result->msg = 'แก้ไขข้อมูลสำเร็จ!.....';

            $this->response = $result;
            return true;
        } catch (Exception $e) {
            $result->status = 'error';
            $result->msg = 'แก้ไขข้อมูลไม่สำเร็จ! ' . $e->getMessage();
            $this->response = $result;
            return false;
        }
    }

    public function deleteOrders()
    {
        $this->order_status =  'cancel';

        $result = new stdClass();

        if ($this->order_key === null || $this->order_key === '') {
            $result->status = 'error';
            $result->msg = 'กรุณาระบุคีย์ให้ถูกต้อง ';
            $this->response = $result;
            return false;
        }
        try {

            DB::query(
                "UPDATE `Orders` SET  `order_status` = '{$this->order_status}' WHERE `Orders`.`order_key` = {$this->order_key};"
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





    /**
     * Get the value of order_key
     */ 
    public function getOrder_key()
    {
        return $this->order_key;
    }

    /**
     * Set the value of order_key
     *
     * @return  self
     */ 
    public function setOrder_key($order_key)
    {
        $this->order_key = $order_key;

        return $this;
    }

    /**
     * Get the value of order_code
     */ 
    public function getOrder_code()
    {
        return $this->order_code;
    }

    /**
     * Set the value of order_code
     *
     * @return  self
     */ 
    public function setOrder_code($order_code = 10)
    {
        $this->order_code = generateRandomStringIM($order_code);

        return $this;
    }

    /**
     * Get the value of account_key
     */ 
    public function getAccount_key()
    {
        return $this->account_key;
    }

    /**
     * Set the value of account_key
     *
     * @return  self
     */ 
    public function setAccount_key($account_key)
    {
        $this->account_key = $account_key;

        return $this;
    }

    /**
     * Get the value of order_price
     */ 
    public function getOrder_price()
    {
        return $this->order_price;
    }

    /**
     * Set the value of order_price
     *
     * @return  self
     */ 
    public function setOrder_price($order_price)
    {
        $this->order_price = $order_price;

        return $this;
    }

    /**
     * Get the value of order_delivery
     */ 
    public function getOrder_delivery()
    {
        return $this->order_delivery;
    }

    /**
     * Set the value of order_delivery
     *
     * @return  self
     */ 
    public function setOrder_delivery($order_delivery)
    {
        $this->order_delivery = $order_delivery;

        return $this;
    }

    /**
     * Get the value of order_price_delivery
     */ 
    public function getOrder_price_delivery()
    {
        return $this->order_price_delivery;
    }

    /**
     * Set the value of order_price_delivery
     *
     * @return  self
     */ 
    public function setOrder_price_delivery($order_price_delivery)
    {
        $this->order_price_delivery = $order_price_delivery;

        return $this;
    }

    /**
     * Get the value of order_date
     */ 
    public function getOrder_date()
    {
        return $this->order_date;
    }

    /**
     * Set the value of order_date
     *
     * @return  self
     */ 
    public function setOrder_date($order_date)
    {
        $this->order_date = $order_date;

        return $this;
    }

    /**
     * Get the value of order_status
     */ 
    public function getOrder_status()
    {
        return $this->order_status;
    }

    /**
     * Set the value of order_status
     *
     * @return  self
     */ 
    public function setOrder_status($order_status)
    {
        $this->order_status = $order_status;

        return $this;
    }
}

?>