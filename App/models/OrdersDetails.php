<?php
require_once __DIR__ . '/./Payments.php';

use Leaf\Form;

class OrderDetails 
{
    # code...
    private $ordetail_key ;
    private $order_key  ;
    private $product_key  ;
    private $ordetail_item ;
    private $ordetail_price ;
    private $ordetail_status ;
    private $Tables = 'orders_details';

    public $response = null;

    public function __construct (){

    }


    
    public function getShowOrderDetailsAll($ATTR_DEFAULT = PDO::FETCH_OBJ)
    { // return OBJ 
        $result = new stdClass();
        $this->ordetail_status = $this->ordetail_status ?? 'show';

        try {

            $qurey = DB::query("SELECT * FROM `orders_details` WHERE ordetail_status = '{$this->ordetail_status}'", $ATTR_DEFAULT)->fetchAll($ATTR_DEFAULT); // false
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

    public function getShowOrderDetailsOne($key, $ATTR_DEFAULT = PDO::FETCH_OBJ)
    {
        $key = Form::sanitizeInput($key  );
        $result = new stdClass();

        try {
            $sql = sprintf("SELECT * FROM  `orders_details` WHERE ordetail_key = '%s';", $key);

            $result->status = 'success';
            $result->msg = 'ดึงข้อมูล สำเร็จ';

            $this->response = $result;
            return DB::query($sql, $ATTR_DEFAULT)->fetch($ATTR_DEFAULT);
        } catch (Exception $e) {
            return null;
        }
    }

    function getSelectOrdersDetails($cond = null, $ATTR_DEFAULT = PDO::FETCH_OBJ)
    {
        $response = new stdClass();
        $sql = "SELECT * FROM ".$this->Tables. ' ';
        if ($cond !== null) {
            $sql .= " WHERE $cond ";
        }

        try {
            return DB::query($sql, $ATTR_DEFAULT)->fetchAll($ATTR_DEFAULT);
        } catch (PDOException $e) {
            $response->status = 'error';
            $response->msg = 'error!'.$e->getMessage();
            $this->response = $response;
            return null;
        }
    }


    public function getShowOrderDetailsAllKey($key = null, $valueID, $ATTR_DEFAULT = PDO::FETCH_OBJ)
    {
        $key = Form::sanitizeInput($key ?? 'order_key' );
        $valueID = Form::sanitizeInput($valueID);

        $result = new stdClass();

        try {
            $sql = sprintf("SELECT * FROM  `orders_details` WHERE {$key} = '{$valueID}';");

            $result->status = 'success';
            $result->msg = 'ดึงข้อมูล สำเร็จ';

            $this->response = $result;
            return DB::query($sql, $ATTR_DEFAULT)->fetchAll($ATTR_DEFAULT);
        } catch (Exception $e) {
            return null;
        }
    }
    public function insertOrderDetails() //เพิ่ม
    {

        $result = new stdClass();
        $this->ordetail_status = $this->ordetail_status ?? 'show';

        $order_key = $this->order_key ?? false;
        $ordetail_item = $this->ordetail_item ?? false;
        $product_key = $this->product_key ?? false;
        $ordetail_price = $this->ordetail_price ?? false;


        if (!$order_key  || !$ordetail_item || !$product_key || !$ordetail_price  ) {
            $result->status = 'error';
            $result->msg = 'กรุณากรอกข้อมูลให้ครบถ้วน!';
            $this->response = $result;
            return false;
        }


        // $resultOrderDetails = $this->getShowOrderDetailsAll(PDO::FETCH_ASSOC) ?? [];

        // $isCheckData  = array_reduce(array_filter(
        //     $resultOrderDetails,
        //     function ($var) {
        //         return $var['order_key'] === $this->order_key;
        //     }
        // ), function () {
        //     return false;
        // }, true);



        // if (!$isCheckData) {
        //     $result->status = 'error';
        //     $result->msg = 'พบหัวข้อซ้ำ';
        //     $this->response = $result;
        //     return false;
        // }

        try {

            $sql = sprintf(
                "INSERT INTO `orders_details` (`ordetail_key`, `order_key`, `product_key`, `ordetail_item`, `ordetail_price`, `ordetail_status`) 
                                        VALUES (NULL, '%s', '%s', '%s', '%s', '%s');",
                $this->order_key,
                $this->product_key,
                $this->ordetail_item,
                $this->ordetail_price,
                $this->ordetail_status,
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
    public function updateOrderDetails()
    {

        $result = new stdClass();

        if ($this->ordetail_key === null || $this->ordetail_key === '') {
            $result->status = 'error';
            $result->msg = 'กรุณาระบุคีย์ ';
            $this->response = $result;
            return false;
        }

        $OrderDetailsResult = $this->getShowOrderDetailsOne($this->ordetail_key);

        $this->order_key = $this->order_key ?? $OrderDetailsResult->order_key;
        $this->product_key = $this->product_key ?? $OrderDetailsResult->product_key;
        $this->ordetail_item = $this->ordetail_item ?? $OrderDetailsResult->ordetail_item;
        $this->ordetail_price = $this->ordetail_price ?? $OrderDetailsResult->ordetail_price;
        $this->ordetail_status = $this->ordetail_status ?? 'show';


        // $OrderDetailsResultALL = $this->getShowOrderDetailsAll(PDO::FETCH_ASSOC);
        // $filterData  = array_filter(
        //     $OrderDetailsResultALL,
        //     function ($var) use ($OrderDetailsResult) {
        //         return ($var['order_key'] !== $OrderDetailsResult->order_key && $var['ordetail_item'] !== $OrderDetailsResult->ordetail_item);
        //     }
        // );

        // $isCheckDataAllow  = array_reduce(array_filter(
        //     $filterData,
        //     function ($var) {
        //         return $var['order_key'] === $this->order_key && $var['ordetail_item'] === $this->ordetail_item;
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
                "UPDATE `orders_details` SET 
                                    `order_key` = '%s', 
                                    `product_key` = '%s', 
                                    `ordetail_item` = '%s', 
                                    `ordetail_price` = '%s',
                                    `ordetail_status` = '%s'
                                    WHERE `orders_details`.`ordetail_key` = '%s';",
                $this->order_key,
                $this->product_key,
                $this->ordetail_item,
                $this->ordetail_price,
                $this->ordetail_status,
                $this->ordetail_key

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

    public function deleteOrderDetails()
    {
        $this->ordetail_status =  'delete';

        $result = new stdClass();

        if ($this->order_key === null || $this->order_key === '') {
            $result->status = 'error';
            $result->msg = 'กรุณาระบุคีย์ให้ถูกต้อง ';
            $this->response = $result;
            return false;
        }
        try {

            DB::query(
                "UPDATE `orders_details` SET  `ordetail_status` = '{$this->ordetail_status}' WHERE `orders_details`.`order_key` = {$this->ordetail_key};"
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
     * Get the value of ordetail_key
     */ 
    public function getOrdetail_key()
    {
        return $this->ordetail_key;
    }

    /**
     * Set the value of ordetail_key
     *
     * @return  self
     */ 
    public function setOrdetail_key($ordetail_key)
    {
        $this->ordetail_key = $ordetail_key;

        return $this;
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
     * Get the value of product_key
     */ 
    public function getProduct_key()
    {
        return $this->product_key;
    }

    /**
     * Set the value of product_key
     *
     * @return  self
     */ 
    public function setProduct_key($product_key)
    {
        $this->product_key = $product_key;

        return $this;
    }

    /**
     * Get the value of ordetail_item
     */ 
    public function getOrdetail_item()
    {
        return $this->ordetail_item;
    }

    /**
     * Set the value of ordetail_item
     *
     * @return  self
     */ 
    public function setOrdetail_item($ordetail_item)
    {
        $this->ordetail_item = $ordetail_item;

        return $this;
    }

    /**
     * Get the value of ordetail_price
     */ 
    public function getOrdetail_price()
    {
        return $this->ordetail_price;
    }

    /**
     * Set the value of ordetail_price
     *
     * @return  self
     */ 
    public function setOrdetail_price($ordetail_price)
    {
        $this->ordetail_price = $ordetail_price;

        return $this;
    }

    /**
     * Get the value of ordetail_status
     */ 
    public function getOrdetail_status()
    {
        return $this->ordetail_status;
    }

    /**
     * Set the value of ordetail_status
     *
     * @return  self
     */ 
    public function setOrdetail_status($ordetail_status)
    {
        $this->ordetail_status = $ordetail_status;

        return $this;
    }
}
