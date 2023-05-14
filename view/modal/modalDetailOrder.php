<?php

date_default_timezone_set('Asia/Bangkok');

require_once __DIR__ . '/../../App/config/connectdb.php';
require_once __DIR__ . '/../../App/models/Orders.php';
require_once __DIR__ . '/../../App/models/Payments.php';
require_once __DIR__ . '/../../App/models/OrdersDetails.php';
require_once __DIR__ . '/../../App/models/Products.php';
require_once __DIR__ . '/../../App/models/Accounts.php';


if (!isset($_POST['action'])) {
    return false;
}

$order_key = isset($_POST['order_key']) ? $_POST['order_key'] : false;

if (!$order_key) {
    return false;
}

$order = new Orders();
$responsOreder = $order->getShowOrdersOne($order_key);



$accountModalOrderDetail = new Accounts();
$accountModalOrderDetail->getShowAccountsOne($responsOreder->account_key);


$orderDetails = new OrderDetails();
$responsorderDetails = $orderDetails->getShowOrderDetailsAllKey('order_key', $order_key);


?>



<!-- Fullscreen Modal -->
<div class="modal fade "  id="showDetailOrder" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered  modal-dialog-scrollable" style='width: 100%;'>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">รายการสินค้า</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <h4><?php echo $responsOreder->order_code ?></h4>
                    </div>
                    <div class="col text-right">
                        <h4><?php echo thaidate('J F Y', $responsOreder->order_date) ?></h4>
                    </div>
                </div>
                <?php
                $payment = new Payments();
                $payment_data = $payment->getShowPaymentsAllKey('order_key', $order_key, PDO::FETCH_OBJ) ?? false;

                // print_r($payment_data);
                if ($payment_data) :
                    foreach ($payment_data as $key => $value) :
                ?>
                        <h5 class="pt-3">ชำระครั้งที่ <?php echo $key + 1 ?></h5>
                        <div class="row ">
                            <div class="col">
                                <h6> ยอดชำระ :<?php echo $value->payment_amount ?></h6>
                            </div>
                            <div class="col text-right">
                                <h6>ชำระวันที่ : <?php echo thaidate('J F Y', $value->payment_time) ?></h6>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <div class="order_box pt-3">
                    <?php
                    // print_r($responsorderDetails); 
                    ?>
                    <h2>คำสั่งของคุณ</h2>
                    <ul class="list">
                        <?php

                        foreach ($responsorderDetails as $key => $value) :
                            $product = new Products();
                            $product->getShowProductsOne($value->product_key)
                        ?>
                            <li>
                                <a href="javascript:void(0)"><?php echo $product->getProduct_name() ?><span class="middle"> x <?php echo $value->ordetail_item ?></span><span class="last">฿<?php echo $value->ordetail_price ?>.00</span></a>
                            </li>

                        <?php endforeach; ?>
                    </ul>
                    <ul class="list" id="tbb_product_item_all_check">

                    </ul>
                    <ul class="list list_2">
                        <li><a href="javascript:void(0)">ยอดรวม <span>฿<?php echo $responsOreder->order_price ?>.00</span></a></li>
                        <li><a href="javascript:void(0)">ค่าจัดส่ง <span>฿<?php echo $responsOreder->order_price_delivery ?>.00</span></a></li>
                        <li><a href="javascript:void(0)">ทั้งหมด <span>฿<?php echo $responsOreder->order_price + $responsOreder->order_price_delivery ?>.00</span></a></li>
                    </ul>
                </div>

                <div class="order_box pt-3">
                    <h2>ข้อมูลส่วนตัว</h2>
                    <div class="row">
                        <div class="col">
                            <h6>ชื่อ </h6>
                        </div>
                        <div class="col text-left">
                            <h6><?php echo $accountModalOrderDetail->getAccount_name() ?></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h6>อีเมล </h6>
                        </div>
                        <div class="col text-left">
                            <h6><?php echo $accountModalOrderDetail->getAccount_email() ?></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h6>เบอร์ติดต่อ </h6>
                        </div>
                        <div class="col text-left">
                            <h6><?php echo $accountModalOrderDetail->getAccount_phone() ?></h6>
                        </div>
                    </div>
                </div>

                <div class="order_box pt-3">
                    <h2>ที่อยู่จัดส่ง</h2>
                    <p><?php echo $responsOreder->order_delivery ?></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>