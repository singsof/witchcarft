<?php
ob_start();

date_default_timezone_set('Asia/Bangkok');

session_start();
require_once dirname(__FILE__) . "/../config/connectdb.php";



// FormData
$id = $_POST["reservation_id"];
$user_id = $_POST["user_id"];
$status = $_POST["status"] == 'true' ? true : false;
$check = null;


$role = $_SESSION["role"];
$goLink = $role == 'user' ? 'default' : $role;
$statusPlayment = false;

if (isset($_POST['submit'])) {

    if ($status) {

        $sqlText_2 = "UPDATE `reservation` SET `ref_status` = '1' WHERE `reservation`.`reservation_id` = $id;";
        $tem_2 = DB::prepare($sqlText_2);
        if ($tem_2->execute()) :
?>
            <script>
                alert("ชำระเงินสำเร็จ")
                window.location.assign('/view/<?php echo $goLink ?>/list-order.php')
            </script>
<?php

        endif;
    } else {
        try {
            $response = $gateway->purchase(array(
                'amount' => $_POST['amount'],
                'currency' => $_ENV['PAYPAL_CURRENCY'],
                'returnUrl' => "http://badminton.swsoft.com/App/controllers/success_paypal.php?id=$id&price=$total_price",
                'cancelUrl' => "http://badminton.swsoft.com/view/$goLink/",
            ))->send();

            if ($response->isRedirect()) {
                $statusPlayment = true;

                $response->redirect(); // this will automatically forward the customer
            } else {
                // not successful
                echo $response->getMessage();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
