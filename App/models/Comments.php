<?php
require_once __DIR__ . '/../config/connectdb.php';

use Leaf\Form;

class Comments
{
    private $comment_key = null;
    private $comment_title = null;
    private $comment_detail = null;
    private $account_key = null;
    private $product_key = null;
    private $comment_postdate = null;
    private $comment_status = null;

    public $response = null;





    public function getShowCommentsAll($ATTR_DEFAULT = PDO::FETCH_OBJ)
    { // return OBJ 
        $result = new stdClass();
        $this->comment_status = $this->comment_status ?? 'show';

        try {


            $qurey = DB::query("SELECT * FROM  `comments` WHERE comment_status = '{$this->comment_status}'", $ATTR_DEFAULT)->fetchAll($ATTR_DEFAULT); // false
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

    public function getShowCommentsOne($key, $ATTR_DEFAULT = PDO::FETCH_OBJ)
    {
        $key = Form::sanitizeInput($key);
        $result = new stdClass();

        try {
            $sql = sprintf("SELECT * FROM `comments` WHERE comment_key = '%s';", $key);

            $result->status = 'success';
            $result->msg = 'ดึงข้อมูล สำเร็จ';

            $this->response = $result;

            $stmt = DB::query($sql, $ATTR_DEFAULT)->fetch($ATTR_DEFAULT);

            $this->comment_key = $stmt->comment_key;
            $this->comment_title = $stmt->comment_title;
            $this->comment_detail = $stmt->comment_detail;
            $this->account_key = $stmt->account_key;
            $this->product_key = $stmt->product_key;
            $this->comment_postdate = $stmt->comment_postdate;
            $this->comment_status = $stmt->comment_status;

            return $stmt;
        } catch (Exception $e) {
            return null;
        }
    }
    public function getShowCommentsCardAllKey($key = null, $valueID, $ATTR_DEFAULT = PDO::FETCH_OBJ)
    {
        $key = Form::sanitizeInput($key ?? 'product_key' );
        $valueID = Form::sanitizeInput($valueID);

        $result = new stdClass();

        try {
            $sql = sprintf("SELECT * FROM `comments` WHERE {$key} = '{$valueID}';");

            $result->status = 'success';
            $result->msg = 'ดึงข้อมูล สำเร็จ';

            $this->response = $result;
            return DB::query($sql, $ATTR_DEFAULT)->fetchAll($ATTR_DEFAULT);
        } catch (Exception $e) {
            return null;
        }
    }
    public function insertComments() //เพิ่ม
    {

        $result = new stdClass();
        $this->comment_status = $this->comment_status ?? 'show';

        $comment_title = $this->comment_title ?? false;
        $product_key = $this->product_key ?? false;
        $account_key = $this->account_key ?? false;
        $comment_detail = $this->comment_detail ?? false;


        if (!$comment_title  || !$product_key || !$account_key || !$comment_detail) {
            $result->status = 'error';
            $result->msg = 'กรุณากรอกข้อมูลให้ครบถ้วน!';
            $this->response = $result;
            return false;
        }


        // $resultComments = $this->getShowCommentsAll(PDO::FETCH_ASSOC) ?? [];

        // $isCheckData  = array_reduce(array_filter(
        //     $resultComments,
        //     function ($var) {
        //         return $var['comment_title'] === $this->comment_title;
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
                "INSERT INTO `comments` (`comment_key`, `comment_title`, `comment_detail`, `account_key`, `product_key`, `comment_postdate`, `comment_status`) 
                                            VALUES (NULL, '%s', '%s', '%s', '%s', current_timestamp(), '%s');",
                $this->comment_title,
                $this->comment_detail,
                $this->account_key,
                $this->product_key,
                $this->comment_status,
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
    public function updateComments()
    {

        $result = new stdClass();

        if ($this->comment_key === null || $this->comment_key === '') {
            $result->status = 'error';
            $result->msg = 'กรุณาระบุคีย์ ';
            $this->response = $result;
            return false;
        }

        $CommentsResult = $this->getShowCommentsOne($this->comment_key);

        $this->product_key = $this->product_key ?? $CommentsResult->product_key;
        $this->comment_title = $this->comment_title ?? $CommentsResult->comment_title;
        $this->comment_detail = $this->comment_detail ?? $CommentsResult->comment_detail;
        $this->account_key = $this->account_key ?? $CommentsResult->account_key;
        $this->comment_status = $this->comment_status ?? 'show';


        // $CommentsResultALL = $this->getShowCommentsAll(PDO::FETCH_ASSOC);
        // $filterData  = array_filter(
        //     $CommentsResultALL,
        //     function ($var) use ($CommentsResult) {
        //         return ($var['comment_title'] !== $CommentsResult->comment_title && $var['product_key'] !== $CommentsResult->product_key);
        //     }
        // );

        // $isCheckDataAllow  = array_reduce(array_filter(
        //     $filterData,
        //     function ($var) {
        //         return $var['comment_title'] === $this->comment_title && $var['product_key'] === $this->product_key;
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
                "UPDATE `comments` SET 
                                    `comment_title` = '%s', 
                                    `comment_detail` = '%s', 
                                    `product_key` = '%s', 
                                    `comment_status` = '%s',
                                    `account_key` = '%s'
                                    WHERE `comments`.`comment_key` = '%s';",
                $this->comment_title,
                $this->comment_detail,
                $this->product_key,
                $this->comment_status,
                $this->account_key,
                $this->comment_key

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

    public function deleteComments()
    {
        $this->comment_status =  'delete';

        $result = new stdClass();

        if ($this->comment_key === null || $this->comment_key === '') {
            $result->status = 'error';
            $result->msg = 'กรุณาระบุคีย์ให้ถูกต้อง ';
            $this->response = $result;
            return false;
        }
        try {

            DB::query(
                "UPDATE `comments` SET  `comment_status` = '{$this->comment_status}' WHERE `comments`.`comment_key` = {$this->comment_key};"
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
     * Get the value of comment_title
     */
    public function getComment_title()
    {
        return $this->comment_title;
    }

    /**
     * Set the value of comment_title
     *
     * @return  self
     */
    public function setComment_title($comment_title)
    {
        $this->comment_title = Form::sanitizeInput($comment_title);

        return $this;
    }

    /**
     * Get the value of comment_detail
     */
    public function getComment_detail()
    {
        return $this->comment_detail;
    }

    /**
     * Set the value of comment_detail
     *
     * @return  self
     */
    public function setComment_detail($comment_detail)
    {
        $this->comment_detail = Form::sanitizeInput($comment_detail);

        return $this;
    }

    /**
     * Get the value of comment_postdate
     */
    public function getComment_postdate()
    {
        return $this->comment_postdate;
    }

    /**
     * Set the value of comment_postdate
     *
     * @return  self
     */
    public function setComment_postdate($comment_postdate)
    {
        $this->comment_postdate = Form::sanitizeInput($comment_postdate);

        return $this;
    }

    /**
     * Get the value of comment_status
     */
    public function getComment_status()
    {
        return $this->comment_status;
    }

    /**
     * Set the value of comment_status
     *
     * @return  self
     */
    public function setComment_status($comment_status = 'show')
    {
        $this->comment_status = Form::sanitizeInput($comment_status);

        return $this;
    }

    /**
     * Get the value of comment_key
     */
    public function getComment_key()
    {
        return $this->comment_key;
    }

    /**
     * Set the value of comment_key
     *
     * @return  self
     */
    public function setComment_key($comment_key)
    {
        $this->comment_key = Form::sanitizeInput($comment_key);

        return $this;
    }

    /**
     * Get the value of comment_key
     */
    public function getaccount_key()
    {
        return $this->account_key;
    }

    /**
     * Set the value of account_key
     *
     * @return  self
     */
    public function setaccount_key($account_key)
    {
        $this->account_key = Form::sanitizeInput($account_key);

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
        $this->product_key = Form::sanitizeInput($product_key);

        return $this;
    }
}
