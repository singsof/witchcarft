<?php

require_once __DIR__ . '/./RelationCardProducts.php';

use Leaf\Form;

class TarotCards
{
    private $card_key  = null;
    private $card_name  = null;
    private $card_picture  = null;
    private $card_meaning  = null;
    private $card_detail  = null;
    private $card_status  = null;
    private $imageName = null;

    private $Tables = 'tarotcards';
    public $response = null;

    function __construct()
    {

        # code...
    }



    public function getShowTarotCardsAll($ATTR_DEFAULT = PDO::FETCH_OBJ)
    { // return OBJ 
        $result = new stdClass();
        $this->card_status = $this->card_status ?? 'show';
        try {


            $qurey = DB::query("SELECT * FROM `TarotCards` WHERE card_status = '{$this->card_status}'", $ATTR_DEFAULT)->fetchAll($ATTR_DEFAULT); // false
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

    public function getShowTarotCardsOne($key, $ATTR_DEFAULT = PDO::FETCH_OBJ)
    {
        $key = Form::sanitizeInput($key);
        $result = new stdClass();

        try {
            $sql = sprintf("SELECT * FROM `TarotCards` WHERE %s = '%s'", is_numeric($key) ? 'card_key' : 'card_name', $key);

            $result->status = 'success';
            $result->msg = 'ดึงข้อมูล ' . sprintf(" %s = '%s'", is_numeric($key) ? 'card_key' : 'card_name', $key) . ' สำเร็จ';

            $this->response = $result;
            $stmt = DB::query($sql, $ATTR_DEFAULT)->fetch($ATTR_DEFAULT);

            $this->card_key = $stmt->card_key;
            $this->card_name = $stmt->card_name;
            $this->card_picture = $stmt->card_picture;
            $this->card_meaning = $stmt->card_meaning;
            $this->card_detail = $stmt->card_detail;
            $this->card_status = $stmt->card_status;

            return $stmt;
        } catch (Exception $e) {
            return null;
        }
    }

    private function getShowPrivateTarotCardsOne($key, $ATTR_DEFAULT = PDO::FETCH_OBJ)
    {
        $key = Form::sanitizeInput($key);
        $result = new stdClass();

        try {
            $sql = sprintf("SELECT * FROM `TarotCards` WHERE %s = '%s'", is_numeric($key) ? 'card_key' : 'card_name', $key);

            $result->status = 'success';
            $result->msg = 'ดึงข้อมูล ' . sprintf(" %s = '%s'", is_numeric($key) ? 'card_key' : 'card_name', $key) . ' สำเร็จ';

            $this->response = $result;
            $stmt = DB::query($sql, $ATTR_DEFAULT)->fetch($ATTR_DEFAULT);

            return $stmt;
        } catch (Exception $e) {
            return null;
        }
    }

    function getSelectTarotCards($cond = null, $ATTR_DEFAULT = PDO::FETCH_OBJ)
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

    public function insertTarotCards(): bool //เพิ่ม
    {

        $result = new stdClass();
        $card_status = $this->card_status ?? 'show';

        $card_name = $this->card_name ?? false;
        $card_meaning = $this->card_meaning ?? false;
        $card_picture = $this->card_picture ?? false;
        $card_meaning = $this->card_meaning ?? false;



        if (!$card_name || !$card_picture || !$card_meaning || !$card_meaning) {
            $result->status = 'error';
            $result->msg = 'กรุณากรอกข้อมูลให้ครบถ้วน!';
            $this->response = $result;
            return false;
        }

        $resultTarotCards = $this->getShowTarotCardsAll(PDO::FETCH_ASSOC) ?? new stdClass();

        $isCheckData  = array_reduce(array_filter(
            $resultTarotCards,
            function ($var) {
                return $var['card_name'] === $this->card_name;
            }
        ), function () {
            return false;
        }, true);


        if (!$isCheckData) {
            $result->status = 'error';
            $result->msg = 'ชื่อนี้มีอยู่ในระบบแล้ว';
            $this->response = $result;
            return false;
        }

        try {

            $sql = sprintf(
                "INSERT INTO `tarotcards` 
                                (`card_key`, `card_name`, `card_picture`, `card_meaning`, `card_detail`, `card_status`) 
                                VALUES (NULL, '%s', '%s', '%s', '%s', 'show');",
                $this->card_name,
                $this->card_picture,
                $this->card_meaning,
                $this->card_meaning,
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
    public function updateTarotCards(): bool
    {
        $result = new stdClass();

        if ($this->card_key === null || $this->card_key === '') {
            $result->status = 'error';
            $result->msg = 'กรุณาระบุคีย์ ';
            $this->response = $result;
            return false;
        }

        $TarotCardsResult = $this->getShowPrivateTarotCardsOne($this->card_key);

        $this->card_meaning = $this->card_meaning ?? $TarotCardsResult->card_meaning;
        $this->card_name = $this->card_name ?? $TarotCardsResult->card_name;
        $this->card_picture = $this->card_picture ?? $TarotCardsResult->card_picture;
        $this->card_detail = $this->card_detail ?? $TarotCardsResult->card_detail;
        $this->card_status = $this->card_status ?? 'show';



        $TarotCardsResultALL = $this->getShowTarotCardsAll(PDO::FETCH_ASSOC);
        $filterData  = array_filter(
            $TarotCardsResultALL,
            function ($var) use ($TarotCardsResult) {
                return $var['card_name'] !== $TarotCardsResult->card_name;
            }
        );



        $isCheckDataAllow  = array_reduce(array_filter(
            $filterData,
            function ($account) {
                return $account['card_name'] === $this->card_name;
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
                "UPDATE `TarotCards` SET 
                                    `card_name` = '%s', 
                                    `card_meaning` = '%s', 
                                    `card_picture` = '%s', 
                                    `card_detail` = '%s',
                                    `card_status` = '%s'
                                    WHERE `TarotCards`.`card_key` = '%s';",
                $this->card_name,
                $this->card_meaning,
                $this->card_picture,
                $this->card_detail,
                $this->card_status,
                $this->card_key

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

    public function deleteTarotCards()
    {

        $result = new stdClass();

        if ($this->card_key === null || $this->card_key === '') {
            $result->status = 'error';
            $result->msg = 'กรุณาระบุคีย์ให้ถูกต้อง ';
            $this->response = $result;
            return false;
        }

        $relations = new RelationCardProducts();
        $resultRelationsData = $relations->getShowRelationCardProductsCardAllKey('card_key', $this->card_key);

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
                "DELETE FROM tarotcards WHERE `tarotcards`.`card_key` = {$this->card_key};"
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


    public function uploadeImage($path,$base64_code)
    {
        $result = new stdClass();
        $name = generateRandomStringIM(2) . date("Y_m_d_H_i_s") . generateRandomStringIM(3) . generateRandomStringIM(3) . ".png";
        $this->setImageName($name);

        // return false;
        try {
            if (file_put_contents($path .$name, base64_decode($base64_code))) {
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

    /**
     * Get the value of card_name
     */
    public function getCard_name()
    {
        return $this->card_name;
    }

    /**
     * Set the value of card_name
     *
     * @return  self
     */
    public function setCard_name($card_name)
    {
        $this->card_name = $card_name;

        return $this;
    }

    /**
     * Get the value of card_picture
     */
    public function getCard_picture()
    {
        return $this->card_picture;
    }

    /**
     * Set the value of card_picture
     *
     * @return  self
     */
    public function setCard_picture($card_picture)
    {
        $this->card_picture = $card_picture;

        return $this;
    }

    /**
     * Get the value of card_meaning
     */
    public function getCard_meaning()
    {
        return $this->card_meaning;
    }

    /**
     * Set the value of card_meaning
     *
     * @return  self
     */
    public function setCard_meaning($card_meaning)
    {
        $this->card_meaning = $card_meaning;

        return $this;
    }

    /**
     * Get the value of card_detail
     */
    public function getCard_detail()
    {
        return $this->card_detail;
    }

    /**
     * Set the value of card_detail
     *
     * @return  self
     */
    public function setCard_detail($card_detail)
    {
        $this->card_detail = $card_detail;

        return $this;
    }

    /**
     * Get the value of card_status
     */
    public function getCard_status()
    {
        return $this->card_status;
    }

    /**
     * Set the value of card_status
     *
     * @return  self
     */
    public function setCard_status($card_status)
    {
        $this->card_status = $card_status;

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
