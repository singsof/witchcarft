<?php

use Leaf\Form;

class Products
{
    private $product_key = null;
    private $product_name = null;
    private $product_stock = null;
    private $product_price = null;
    private $product_picture = null;
    private $product_detail = null;
    private $product_update = null;
    private $product_status = null;
    public $response = null;
    private $Tables = 'products';

    private $imageName = null;


    public function __construct()
    {
        // $this->product_status = 'show';
        // $this->Tables = 'products';
    }



    public function getShowProductsAll($ATTR_DEFAULT = PDO::FETCH_OBJ)
    { // return OBJ 
        $result = new stdClass();
        $this->product_status = $this->product_status ?? 'show';

        // $ShowAlls = !$ShowAll ? ' product_status  != "" ORDER BY `products`.`product_key` ASC ' : " && product_status = '{$this->product_status} ";
        // $HideDelete = !$HideDelete ? " ": ' product_status != "delete" && ';
        // $Hide = !$Hide ? " ": " product_status != 'hide' ";
        try {


            $qurey = DB::query("SELECT * FROM `{$this->Tables}` WHERE  product_status ='{$this->product_status}'", $ATTR_DEFAULT)->fetchAll($ATTR_DEFAULT); // false
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

    public function getShowProductsOne($key, $ATTR_DEFAULT = PDO::FETCH_OBJ)
    {
        $key = Form::sanitizeInput($key);
        $result = new stdClass();

        try {
            $sql = sprintf("SELECT * FROM `products` WHERE %s = '%s'", is_numeric($key) ? 'product_key' : 'product_name', $key);

            $result->status = 'success';
            $result->msg = 'ดึงข้อมูล ' . sprintf(" %s = '%s'", is_numeric($key) ? 'product_key' : 'product_name', $key) . ' สำเร็จ';

            $this->response = $result;
            $stml = DB::query($sql, $ATTR_DEFAULT)->fetch($ATTR_DEFAULT);

            $this->product_key = $stml->product_key;
            $this->product_name = $stml->product_name;
            $this->product_picture  = $stml->product_picture;
            $this->product_price = $stml->product_price;
            $this->product_detail = $stml->product_detail;
            $this->product_status = $stml->product_status;
            $this->product_stock = $stml->product_stock;
            $this->product_update = $stml->product_update;


            return $stml;
        } catch (Exception $e) {
            return null;
        }
    }

    private function getShowPrivateProducts($key, $ATTR_DEFAULT = PDO::FETCH_OBJ)
    {
        $key = Form::sanitizeInput($key);
        $result = new stdClass();

        try {
            $sql = sprintf("SELECT * FROM `products` WHERE %s = '%s'", is_numeric($key) ? 'product_key' : 'product_name', $key);

            $result->status = 'success';
            $result->msg = 'ดึงข้อมูล ' . sprintf(" %s = '%s'", is_numeric($key) ? 'product_key' : 'product_name', $key) . ' สำเร็จ';

            $this->response = $result;
            $stml = DB::query($sql, $ATTR_DEFAULT)->fetch($ATTR_DEFAULT);

            return $stml;
        } catch (Exception $e) {
            return null;
        }
    }
    function getSelectProducts($cond = null, $ATTR_DEFAULT = PDO::FETCH_OBJ)
    {
        $response = new stdClass();
        $sql = "SELECT * FROM " . $this->Tables . ' ';
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
            $response->msg = 'error!' . $e->getMessage();
            $this->response = $response;
            return null;
        }
    }

    public function insertProducts(): bool //เพิ่ม
    {

        $result = new stdClass();
        $product_status = $this->product_status ?? 'show';
        $resultProducts = $this->getShowProductsAll(PDO::FETCH_ASSOC) ?? [];

        $product_name = $this->product_name ?? false;
        $product_stock = $this->product_stock ?? false;
        $product_price = $this->product_price ?? false;
        $product_picture = $this->product_picture ?? false;
        $product_detail = $this->product_detail ?? false;

        if (!$product_name || !$product_picture || !$product_detail || !$product_stock || !$product_price) {
            $result->status = 'error';
            $result->msg = 'กรุณากรอกข้อมูลให้ครบถ้วน!';
            $this->response = $result;
            return false;
        }

        $isCheckData  = array_reduce(array_filter(
            $resultProducts,
            function ($var) {
                return $var['product_name'] === $this->product_name && $var['product_status'] !== 'delete';
            }
        ), function () {
            return false;
        }, true);


        if (!$isCheckData) {
            $result->status = 'error';
            $result->msg = 'ชื่อนี้ มีอยู่ในระบบแล้ว';
            $this->response = $result;
            return false;
        }


        try {

            DB::query(
                "INSERT INTO `products` (`product_key`, `product_price`, `product_stock`, `product_name`, `product_picture`, `product_detail`, `product_update`, `product_status`) 
                                VALUES (NULL, '{$this->product_price}', '{$this->product_stock}', '{$this->product_name}', '{$this->product_picture}', '{$this->product_detail}', current_timestamp(), '{$product_status}');"
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
    public function updateProducts(): bool
    {
        $result = new stdClass();

        if ($this->product_key === null || $this->product_key === '') {
            $result->status = 'error';
            $result->msg = 'กรุณาระบุคีย์ ';
            $this->response = $result;
            return false;
        }

        $ProductsResult = $this->getShowProductsOne($this->product_key);

        $this->product_price = $this->product_price ?? $ProductsResult->product_price;
        $this->product_stock = $this->product_stock ?? $ProductsResult->product_stock;
        $this->product_name = $this->product_name ?? $ProductsResult->product_name;
        $this->product_picture = $this->product_picture ?? $ProductsResult->product_picture;
        $this->product_detail = $this->product_detail ?? $ProductsResult->product_detail;
        $this->product_status = $this->product_status ?? 'show';




        $ProductsResultALL = $this->getShowProductsAll(PDO::FETCH_ASSOC);
        $filterData  = array_filter(
            $ProductsResultALL,
            function ($var) use ($ProductsResult) {
                return $var['product_name'] !== $ProductsResult->product_name;
            }
        );

        $isCheckDataAllow  = array_reduce(array_filter(
            $filterData,
            function ($account) {
                return $account['product_name'] === $this->product_name;
            }
        ), function () {
            return false;
        }, true);


        if (!$isCheckDataAllow) {
            $result->status = 'error';
            $result->msg = 'ไม่สามารถใช้ชื่อนี้ได้';
            $this->response = $result;
            return false;
        }



        try {

            $sql = sprintf(
                "UPDATE `products` SET 
                                    `product_name` = '%s', 
                                    `product_stock` = '%s', 
                                    `product_price` = '%s', 
                                    `product_picture` = '%s', 
                                    `product_detail` = '%s',
                                    `product_status` = '%s'
                                    WHERE `products`.`product_key` = '%s';",
                $this->product_name,
                $this->product_stock,
                $this->product_price,
                $this->product_picture,
                $this->product_detail,
                $this->product_status,
                $this->product_key

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

    public function deleteProducts()
    {
        $this->product_status =  'delete';

        $result = new stdClass();

        if ($this->product_key === null || $this->product_key === '') {
            $result->status = 'error';
            $result->msg = 'กรุณาระบุคีย์ให้ถูกต้อง ';
            $this->response = $result;
            return false;
        }

        $relations = new RelationCardProducts();
        $resultRelationsData = $relations->getShowRelationCardProductsCardAllKey('product_key', $this->product_key);

        try {
            foreach ($resultRelationsData as $key => $value) {
                $relationsNew = new RelationCardProducts();
                $relationsNew->setRelation_key($value->relation_key);
                $relationsNew->deleteRelationCardProducts();
            }
        } catch (Exception $e) {
            $result->status = 'error';
            $result->msg = 'ลบข้อมูลไม่สำเร็จ! : ' . $e->getMessage();
            $this->response = $result;
            return false;
        }


        try {

            DB::query(
                "UPDATE `products` SET  `product_status` = '{$this->product_status}' WHERE `products`.`product_key` = {$this->product_key};"
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


    public function uploadeImage($path, $base64_code)
    {
        $result = new stdClass();
        $name = generateRandomStringIM(2) . date("Y_m_d_H_i_s") . generateRandomStringIM(3) . generateRandomStringIM(3) . ".png";
        $this->setImageName($name);

        // return false;
        try {
            if (file_put_contents($path . $name, base64_decode($base64_code))) {
                $result->msg = "success";
                $result->msg_text = 'บันทึกรูปภาพสำเร็จ';
                return true;
            } else {
                $result->msg = "error";
                $result->msg_text = 'กรุณาลองใหม่อีกครั้ง';
                return false;
            }
        } catch (Exception $e) {
            $result->msg = "error";
            $result->msg_text = $e->getMessage();
            return false;
        }
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
        $this->product_key = Form::sanitizeInput($product_key);

        return $this;
    }

    /**
     * Get the value of product_name
     */
    public function getProduct_name()
    {
        return $this->product_name;
    }

    /**
     * Set the value of product_name
     *
     * @return  self
     */
    public function setProduct_name($product_name)
    {
        $this->product_name = Form::sanitizeInput($product_name);

        return $this;
    }

    /**
     * Get the value of product_stock
     */
    public function getProduct_stock()
    {
        return $this->product_stock;
    }

    /**
     * Set the value of product_stock
     *
     * @return  self
     */
    public function setProduct_stock($product_stock)
    {
        $this->product_stock = Form::sanitizeInput($product_stock);

        return $this;
    }

    /**
     * Get the value of product_price
     */
    public function getProduct_price()
    {
        return $this->product_price;
    }

    /**
     * Set the value of product_price
     *
     * @return  self
     */
    public function setProduct_price($product_price)
    {
        $this->product_price = Form::sanitizeInput($product_price);

        return $this;
    }

    /**
     * Get the value of product_picture
     */
    public function getProduct_picture()
    {
        return $this->product_picture;
    }

    /**
     * Set the value of product_picture
     *
     * @return  self
     */
    public function setProduct_picture($product_picture)
    {
        $this->product_picture = Form::sanitizeInput($product_picture);

        return $this;
    }

    /**
     * Get the value of product_detail
     */
    public function getProduct_detail()
    {
        return $this->product_detail;
    }

    /**
     * Set the value of product_detail
     *
     * @return  self
     */
    public function setProduct_detail($product_detail)
    {
        $this->product_detail = Form::sanitizeInput($product_detail);

        return $this;
    }

    /**
     * Get the value of product_update
     */
    public function getProduct_update()
    {
        return $this->product_update;
    }

    /**
     * Set the value of product_update
     *
     * @return  self
     */
    public function setProduct_update($product_update)
    {
        $this->product_update = Form::sanitizeInput($product_update);

        return $this;
    }

    /**
     * Get the value of product_status
     */
    public function getProduct_status()
    {
        return $this->product_status;
    }

    /**
     * Set the value of product_status
     *
     * @return  self
     */
    public function setProduct_status($product_status)
    {
        $this->product_status = Form::sanitizeInput($product_status);

        return $this;
    }

    /**
     * Get the value of imageName
     */ 
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set the value of imageName
     *
     * @return  self
     */ 
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }
}
