<?php 

use Leaf\Form;


class Payments extends Database{
    
    private $payment_key = null;
    private $order_key = null;
    private $payment_amount = null;
    private $payment_method = null;
    private $payment_currency = null;
    private $payment_time = null;
    public $response = null;

    public function __construct (){
        $this->payment_currency = 'THB';
        $this->payment_method = 'cash';
    }





    
    public function getShowPaymentsAll($ATTR_DEFAULT = PDO::FETCH_OBJ)
    { // return OBJ 
        $result = new stdClass();


        try {

            $qurey = DB::query("SELECT * FROM `payments` '", $ATTR_DEFAULT)->fetchAll($ATTR_DEFAULT); // false
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

    public function getShowPaymentsOne($key, $ATTR_DEFAULT = PDO::FETCH_OBJ)
    {
        $key = Form::sanitizeInput($key);
        $result = new stdClass();

        try {
            $sql = sprintf("SELECT * FROM  `payments` WHERE payment_key = '%s';", $key);

            $result->status = 'success';
            $result->msg = 'ดึงข้อมูล สำเร็จ';

            $this->response = $result;
            return DB::query($sql, $ATTR_DEFAULT)->fetch($ATTR_DEFAULT);
        } catch (Exception $e) {
            return null;
        }
    }
    public function getShowPaymentsAllKey($key = null, $valueID, $ATTR_DEFAULT = PDO::FETCH_OBJ)
    {
        $key = Form::sanitizeInput($key ?? 'order_key' );
        $valueID = Form::sanitizeInput($valueID);

        $result = new stdClass();

        try {
            $sql = sprintf("SELECT * FROM  `payments` WHERE {$key} = '{$valueID}';");

            $result->status = 'success';
            $result->msg = 'ดึงข้อมูล สำเร็จ';

            $this->response = $result;
            $stmt = DB::query($sql, $ATTR_DEFAULT)->fetchAll($ATTR_DEFAULT);
            // $count = count($stmt);
            if($stmt === array()){
                return null;
            }
            return  $stmt;
        } catch (Exception $e) {
            return null;
        }
    }
    public function insertPayments() //เพิ่ม
    {

        $result = new stdClass();


        $order_key = $this->order_key ?? false;
        $payment_amount = $this->payment_amount ?? false;
        $payment_method = $this->payment_method ?? false;


        if (!$order_key  || !$payment_amount || !$payment_method  ) {
            $result->status = 'error';
            $result->msg = 'กรุณากรอกข้อมูลให้ครบถ้วน!';
            $this->response = $result;
            return false;
        }


        // $resultPayments = $this->getShowPaymentsAll(PDO::FETCH_ASSOC) ?? [];

        // $isCheckData  = array_reduce(array_filter(
        //     $resultPayments,
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
                "INSERT INTO `payments` (`payment_key`, `order_key`, `payment_amount`, `payment_method`, `payment_currency`, `payment_time`) 
                                VALUES (NULL, '%s', '%s', '%s', '%s', current_timestamp());",
                $this->order_key,
                $this->payment_amount,
                $this->payment_method,
                $this->payment_currency,
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
    public function updatePayments()
    {

        $result = new stdClass();

        if ($this->payment_key === null || $this->payment_key === '') {
            $result->status = 'error';
            $result->msg = 'กรุณาระบุคีย์ ';
            $this->response = $result;
            return false;
        }

        $PaymentsResult = $this->getShowPaymentsOne($this->payment_key);

        $this->order_key = $this->order_key ?? $PaymentsResult->order_key;
        $this->payment_amount = $this->payment_amount ?? $PaymentsResult->payment_amount;
        $this->payment_method = $this->payment_method ?? $PaymentsResult->payment_method;
        $this->payment_currency = $this->payment_currency ?? $PaymentsResult->payment_currency;


        // $PaymentsResultALL = $this->getShowPaymentsAll(PDO::FETCH_ASSOC);
        // $filterData  = array_filter(
        //     $PaymentsResultALL,
        //     function ($var) use ($PaymentsResult) {
        //         return ($var['order_key'] !== $PaymentsResult->order_key && $var['payment_amount'] !== $PaymentsResult->payment_amount);
        //     }
        // );

        // $isCheckDataAllow  = array_reduce(array_filter(
        //     $filterData,
        //     function ($var) {
        //         return $var['order_key'] === $this->order_key && $var['payment_amount'] === $this->payment_amount;
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
                "UPDATE `payments` SET 
                                    `order_key` = '%s', 
                                    `payment_method` = '%s', 
                                    `payment_amount` = '%s', 
                                    `payment_currency` = '%s'
                                    WHERE `payments`.`payment_key` = '%s';",
                $this->order_key,
                $this->payment_method,
                $this->payment_amount,
                $this->payment_currency,
                $this->payment_key
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

    public function deletePayments()
    {
        // $this->ordetail_status =  'delete';

        $result = new stdClass();

        if ($this->payment_key === null || $this->payment_key === '') {
            $result->status = 'error';
            $result->msg = 'กรุณาระบุคีย์ให้ถูกต้อง ';
            $this->response = $result;
            return false;
        }
        try {

            DB::query(
                "DELETE FROM payments WHERE `payments`.`payment_key` = {$this->payment_key}"
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
     * Get the value of payment_key
     */ 
    public function getPayment_key()
    {
        return $this->payment_key;
    }

    /**
     * Set the value of payment_key
     *
     * @return  self
     */ 
    public function setPayment_key($payment_key)
    {
        $this->payment_key = Form::sanitizeInput($payment_key);

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
        $this->order_key = Form::sanitizeInput($order_key);

        return $this;
    }

    /**
     * Get the value of payment_amount
     */ 
    public function getPayment_amount()
    {
        return $this->payment_amount;
    }

    /**
     * Set the value of payment_amount
     *
     * @return  self
     */ 
    public function setPayment_amount($payment_amount)
    {
        $this->payment_amount = Form::sanitizeInput($payment_amount);

        return $this;
    }

    /**
     * Get the value of payment_method
     */ 
    public function getPayment_method()
    {
        return $this->payment_method;
    }

    /**
     * Set the value of payment_method
     *
     * @return  self
     */ 
    public function setPayment_method($payment_method = 'cash')
    {
        $this->payment_method = Form::sanitizeInput($payment_method);

        return $this;
    }

    /**
     * Get the value of payment_currency
     */ 
    public function getPayment_currency()
    {
        return $this->payment_currency;
    }

    /**
     * Set the value of payment_currency
     *
     * @return  self
     */ 
    public function setPayment_currency($payment_currency)
    {
        $this->payment_currency = Form::sanitizeInput($payment_currency);

        return $this;
    }

    /**
     * Get the value of payment_time
     */ 
    public function getPayment_time()
    {
        return $this->payment_time;
    }

    /**
     * Set the value of payment_time
     *
     * @return  self
     */ 
    public function setPayment_time($payment_time)
    {
        $this->payment_time = Form::sanitizeInput($payment_time);

        return $this;
    }
}
