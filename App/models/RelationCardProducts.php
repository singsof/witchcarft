<?php

use Leaf\Form;

class RelationCardProducts
{
    private $relation_key = null;
    private $product_key  = null;
    private $card_key  = null;
    private $relation_status = null;
    public $response = null;

    private $Tables = 'relation_card_product';

    public function __construct()
    {
    }
    public function __destruct()
    {
    }



    public function getShowRelationCardProductsAll($ATTR_DEFAULT = PDO::FETCH_OBJ)
    { // return OBJ 
        $result = new stdClass();
        $this->relation_status = $this->relation_status ?? 'show';
        try {


            $qurey = DB::query("SELECT * FROM  `relation_card_product` WHERE relation_status = '{$this->relation_status}'", $ATTR_DEFAULT)->fetchAll($ATTR_DEFAULT); // false
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

    public function getShowRelationCardProductsOne($key, $ATTR_DEFAULT = PDO::FETCH_OBJ)
    {
        $key = Form::sanitizeInput($key);
        $result = new stdClass();

        try {
            $sql = sprintf("SELECT * FROM `relation_card_product` WHERE relation_key = '%s';", $key);

            $result->status = 'success';
            $result->msg = 'ดึงข้อมูล สำเร็จ';

            $this->response = $result;
            return DB::query($sql, $ATTR_DEFAULT)->fetch($ATTR_DEFAULT);
        } catch (Exception $e) {
            return null;
        }
    }


    function getSelectRelationCardProducts($cond = null, $ATTR_DEFAULT = PDO::FETCH_OBJ)
    {
        $response = new stdClass();
        $sql = "SELECT * FROM " . $this->Tables . ' ';
        if ($cond !== null) {
            $sql .= " WHERE $cond ";
        }

        try {
            return DB::query($sql, $ATTR_DEFAULT)->fetchAll($ATTR_DEFAULT);
        } catch (PDOException $e) {
            $response->status = 'error';
            $response->msg = 'error!' . $e->getMessage();
            $this->response = $response;
            return null;
        }
    }



    public function getShowRelationCardProductsCardAllKey($key = 'card_key', $valueID, $ATTR_DEFAULT = PDO::FETCH_OBJ)
    {
        $key = Form::sanitizeInput($key);
        $valueID = Form::sanitizeInput($valueID);

        $result = new stdClass();

        try {
            $sql = sprintf("SELECT * FROM `relation_card_product` WHERE {$key} = '{$valueID}';");

            $result->status = 'success';
            $result->msg = 'ดึงข้อมูล สำเร็จ';

            $this->response = $result;
            return DB::query($sql, $ATTR_DEFAULT)->fetchAll($ATTR_DEFAULT);
        } catch (Exception $e) {
            return null;
        }
    }
    public function insertRelationCardProducts() //เพิ่ม
    {

        $result = new stdClass();
        $relation_status = $this->relation_status ?? 'show';

        $card_key = $this->card_key ?? false;
        $product_key = $this->product_key ?? false;


        if (!$card_key  || !$product_key) {
            $result->status = 'error';
            $result->msg = 'กรุณากรอกข้อมูลให้ครบถ้วน!';
            $this->response = $result;
            return false;
        }


        $resultRelationCardProducts = $this->getShowRelationCardProductsAll(PDO::FETCH_ASSOC) ?? [];

        $isCheckData  = array_reduce(array_filter(
            $resultRelationCardProducts,
            function ($var) {
                return $var['product_key'] === $this->product_key && $var['card_key'] === $this->card_key;
            }
        ), function () {
            return false;
        }, true);



        if (!$isCheckData) {
            $result->status = 'error';
            $result->msg = 'ข้อมูลซ้ำในระบบ';
            $this->response = $result;
            return false;
        }

        try {

            $sql = sprintf(
                "INSERT INTO `relation_card_product` 
                                (`relation_key`, `card_key`, `product_key`, `relation_status`) 
                                VALUES (NULL, '%s', '%s', 'show');",
                $this->card_key,
                $this->product_key
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
    public function updateRelationCardProducts()
    {

        $result = new stdClass();

        if ($this->relation_key === null || $this->relation_key === '') {
            $result->status = 'error';
            $result->msg = 'กรุณาระบุคีย์ ';
            $this->response = $result;
            return false;
        }

        $RelationCardProductsResult = $this->getShowRelationCardProductsOne($this->relation_key);

        $this->product_key = $this->product_key ?? $RelationCardProductsResult->product_key;
        $this->card_key = $this->card_key ?? $RelationCardProductsResult->card_key;
        $this->relation_status = $this->relation_status ?? 'show';



        $RelationCardProductsResultALL = $this->getShowRelationCardProductsAll(PDO::FETCH_ASSOC);
        $filterData  = array_filter(
            $RelationCardProductsResultALL,
            function ($var) use ($RelationCardProductsResult) {
                return ($var['card_key'] !== $RelationCardProductsResult->card_key && $var['product_key'] !== $RelationCardProductsResult->product_key);
            }
        );

        $isCheckDataAllow  = array_reduce(array_filter(
            $filterData,
            function ($var) {
                return $var['card_key'] === $this->card_key && $var['product_key'] === $this->product_key;
            }
        ), function () {
            return false;
        }, true);


        if (!$isCheckDataAllow) {
            $result->status = 'error';
            $result->msg = 'ไม่สามารถใช้คีย์การ์ด หรือคีย์สินค้า นี้ได้';
            $this->response = $result;
            return false;
        }

        try {

            $sql = sprintf(
                "UPDATE `relation_card_product` SET 
                                    `card_key` = '%s', 
                                    `product_key` = '%s', 
                                    `relation_status` = '%s'
                                    WHERE `relation_card_product`.`relation_key` = '%s';",
                $this->card_key,
                $this->product_key,
                $this->relation_status,
                $this->relation_key

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

    public function deleteRelationCardProducts()
    {

        $result = new stdClass();

        if ($this->relation_key === null || $this->relation_key === '') {
            $result->status = 'error';
            $result->msg = 'กรุณาระบุคีย์ให้ถูกต้อง ';
            $this->response = $result;
            return false;
        }
        try {

            DB::query(
                "DELETE FROM relation_card_product WHERE `relation_card_product`.`relation_key` = '{$this->relation_key}'"
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
     * Get the value of relation_key
     */
    public function getRelation_key()
    {
        return $this->relation_key;
    }

    /**
     * Set the value of relation_key
     *
     * @return  self
     */
    public function setRelation_key($relation_key)
    {
        $this->relation_key = $relation_key;

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
     * Get the value of relation_key
     */


    /**
     * Get the value of relation_status
     */
    public function getrelation_status()
    {
        return $this->relation_status;
    }

    /**
     * Set the value of relation_status
     *
     * @return  self
     */
    public function setrelation_status($relation_status)
    {
        $this->relation_status = $relation_status;

        return $this;
    }

    /**
     * Get the value of card_key
     */
    public function getCard_key()
    {
        return $this->card_key;
    }

    /**
     * Set the value of card_key
     *
     * @return  self
     */
    public function setCard_key($card_key)
    {
        $this->card_key = $card_key;

        return $this;
    }
}
