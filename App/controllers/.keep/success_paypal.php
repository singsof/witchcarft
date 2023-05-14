<?php
ob_start();

date_default_timezone_set('Asia/Bangkok');

session_start();
require_once dirname(__FILE__) . "/../config/connectdb.php";
$role = $_SESSION["role"];
$goLink = $role == 'user' ? 'default' : $role;


// Once the transaction has been approved, we need to complete it.
if (array_key_exists('paymentId', $_GET) && array_key_exists('PayerID', $_GET)) {
    // $_GET['PayerID']

    $id = $_GET['id'];
    $total_price = $_GET['price'];

    $transaction = $gateway->completePurchase(array(
        'payer_id'             => $_GET['PayerID'],
        'transactionReference' => $_GET['paymentId'],
    ));
    $response = $transaction->send();

    if ($response->isSuccessful()) {
        // The customer has successfully paid.
        $arr_body = $response->getData();

        $payment_id = $arr_body['id'];
        $payer_id = $arr_body['payer']['payer_info']['payer_id'];
        $payer_email = $arr_body['payer']['payer_info']['email'];
        $amount = $arr_body['transactions'][0]['amount']['total'];
        $currency = $_ENV['PAYPAL_CURRENCY'];
        $payment_status = $arr_body['state'];

        // $check = DB::query("SELECT * FROM `reservation` WHERE reservation_id = '$id'",PDO::FETCH_OBJ)->fetch(PDO::FETCH_OBJ)->ref_status == 4 ? true : false;

        // if(!$check){

        // }


       $sqlText_1 = "INSERT INTO `payment` (`payment_id`, `reservation_id`, `payment_date`, `payment_method`, `payment_amount`) 
                                            VALUES (NULL, '$id', current_timestamp() , 'paypal', '$amount');";
        $tem_1 = DB::prepare($sqlText_1); 

        $sqlText_2 = "UPDATE `reservation` SET `ref_status` = '1' WHERE `reservation`.`reservation_id` = $id;";
        $tem_2 = DB::prepare($sqlText_2);
        $tem_2->execute();


        if ($tem_1->execute()) :

?>
            <script>
                alert("ชำระเงินสำเร็จ")
                window.location.assign('/view/<?php echo $goLink ?>/list-order.php')
            </script>
<?php
        endif;
    } else {
        echo $response->getMessage();
    }
} else {
    echo 'Transaction is declined';
}
