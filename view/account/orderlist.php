<?php include_once __DIR__ . '/./layouts/top_head.php' ?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->

    <!-- Author Meta -->
    <meta name="author" content="CodePixar">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>รายการคำสั่งซื้อ - <?php echo $_ENV['APP_NAME'] ?></title>


    <?php include_once __DIR__ . '/./layouts/header.php' ?>
    <?php include_once __DIR__ . '/./layouts/script.php' ?>



    <?php
    $_Account = new Accounts();
    $_Account->getShowAccountsOne($_Account_id);
    $Orders = new Orders();
    $OrdersDataAll = $Orders->getSelectOrders(sprintf(" account_key = {$_Account->getAccount_id()}"), PDO::FETCH_OBJ);

    // print_r($OrdersDataAll);

    // $OrdersDelail = new OrderDetails();
    // $OrdersDelailData = $OrdersDelail->getShowOrderDetailsAllKey(null,$OrdersDataAll->order_key);
    $OrdersWait = array_filter(
        $OrdersDataAll,
        function ($var) {
            return  $var->order_status === 'wait';
        }
    );

    // $OrdersConfirm = array_filter(
    //     $OrdersDataAll,
    //     function ($var) {
    //         return  $var->order_status === 'confirm';
    //     }
    // );
    $OrdersSending = array_filter(
        $OrdersDataAll,
        function ($var) {
            return  $var->order_status === 'sending';
        }
    );
    $OrdersSuccess = array_filter(
        $OrdersDataAll,
        function ($var) {
            return  $var->order_status === 'success';
        }
    );
    $Orderscancel = array_filter(
        $OrdersDataAll,
        function ($var) {
            return  $var->order_status === 'cancel';
        }
    );





    ?>

</head>

<body>

    <?php include_once __DIR__ . '/layouts/navbar.php' ?>
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>สถานะคำสั่งซื้อ</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.php">หน้าหลัก<span class="lnr lnr-arrow-right"></span></a>
                        <a href="่javascript:void(0)">สถานะคำสั่งซื้อ</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================End Single Product Area =================-->

    <!--================Product Description Area =================-->
    <section class="product_description_area">
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link show active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">รายการคำสั่งซื้อ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " id="sanding-tab" data-toggle="tab" href="#sanding" role="tab" aria-controls="sanding" aria-selected="false">กำลังจัดส่ง</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " id="success-tab" data-toggle="tab" href="#success" role="tab" aria-controls="success" aria-selected="false">จัดส่งสำเร็จ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " id="cancel-tab" data-toggle="tab" href="#cancel" role="tab" aria-controls="cancel" aria-selected="false">ยกเลิก</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                    <h3>รอยืนยังคำสั่งซื้อ</h3>
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">ลำดับ</th>
                                <th scope="col">รหัสออเดอร์</th>
                                <th scope="col">ราคารวม</th>
                                <th scope="col">ค่าขนส่ง</th>
                                <th scope="col">วันที่สั่งซื้อ</th>
                                <th scope="col">การชำระเงิน</th>
                                <th scope="col">รายละเอียด</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            $detail_i  = 1;
                            foreach ($OrdersWait as $key => $value) :
                                $payment = new Payments();
                                $payment_data = $payment->getShowPaymentsAllKey('order_key', $value->order_key, PDO::FETCH_ASSOC) ?? [['payment_method' => 'รอชำระเงิน']];
                                // $detail->getShowOrderDetailsOne($value->order_key)

                            ?>
                                <tr class="text-left">
                                    <th scope="row" class="text-center"><?php echo  $detail_i++; ?></th>
                                    <td><?php echo $value->order_code ?></td>
                                    <td>฿<?php echo $value->order_price ?>.00</td>
                                    <td>฿<?php echo $value->order_price_delivery ?>.00</td>
                                    <td><?php echo thaidate('j F Y', $value->order_date) ?></td>
                                    <td><span class="badge badge-pill badge-warning "><?php echo $payment_data[0]['payment_method'] ?></span></td>
                                    <td>
                                        <a href="javascript:modalDetailOrder(<?php echo $value->order_key ?>)"><span class="badge badge-pill  badge-primary ">รายละเอียด</span></a>
                                        <a href="javascript:cancelOrderButton(<?php echo $value->order_key ?>)"><span class="badge badge-pill badge-danger ">ยกเลิก</span></a>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>



                </div>
                <div class="tab-pane fade " id="sanding" role="tabpanel" aria-labelledby="sanding-tab">
                    <h3>กำลังจัดส่ง</h3>
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">ลำดับ</th>
                                <th scope="col">รหัสออเดอร์</th>
                                <th scope="col">ราคารวม</th>
                                <th scope="col">ค่าขนส่ง</th>
                                <th scope="col">วันที่สั่งซื้อ</th>
                                <th scope="col">การชำระเงิน</th>
                                <th scope="col">รายละเอียด</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            $detail_i  = 1;
                            foreach ($OrdersSending as $key => $value) :
                                $payment_OrdersSending = new Payments();
                                $payment_data = $payment_OrdersSending->getShowPaymentsAllKey('order_key', $value->order_key, PDO::FETCH_ASSOC) ?? [['payment_method' => 'รอชำระเงิน']];
                                // $detail->getShowOrderDetailsOne($value->order_key)
                                // var_dump($payment_data);

                            ?>
                                <tr class="text-left">
                                    <th scope="row" class="text-center"><?php echo  $detail_i++; ?></th>
                                    <td><?php echo $value->order_code ?></td>
                                    <td>฿<?php echo $value->order_price ?>.00</td>
                                    <td>฿<?php echo $value->order_price_delivery ?>.00</td>
                                    <td><?php echo thaidate('j F Y', $value->order_date) ?></td>
                                    <td><span class="badge badge-pill badge-warning "><?php echo $payment_data[0]['payment_method'] ?></span></td>
                                    <td>
                                        <a href="javascript:modalDetailOrder(<?php echo $value->order_key ?>)"><span class="badge badge-pill  badge-primary ">รายละเอียด</span></a>
                                        <a href="javascript:pickUpOrderButton(<?php echo $value->order_key ?>)"><span class="badge badge-pill badge-danger ">ได้รับสินค้า</span></a>

                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade " id="success" role="tabpanel" aria-labelledby="success-tab">
                    <h3>จัดส่งสำเร็จ</h3>
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">ลำดับ</th>
                                <th scope="col">รหัสออเดอร์</th>
                                <th scope="col">ราคารวม</th>
                                <th scope="col">ค่าขนส่ง</th>
                                <th scope="col">วันที่สั่งซื้อ</th>
                                <th scope="col">การชำระเงิน</th>
                                <th scope="col">รายละเอียด</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            $detail_i  = 1;
                            foreach ($OrdersSuccess as $key => $value) :
                                $payment_OrdersOrdersSuccess = new Payments();
                                $payment_data = $payment_OrdersOrdersSuccess->getShowPaymentsAllKey('order_key', $value->order_key, PDO::FETCH_ASSOC) ?? [['payment_method' => 'รอชำระเงิน']];
                                // $detail->getShowOrderDetailsOne($value->order_key)
                                // var_dump($payment_data);

                            ?>
                                <tr class="text-left">
                                    <th scope="row" class="text-center"><?php echo  $detail_i++; ?></th>
                                    <td><?php echo $value->order_code ?></td>
                                    <td>฿<?php echo $value->order_price ?>.00</td>
                                    <td>฿<?php echo $value->order_price_delivery ?>.00</td>
                                    <td><?php echo thaidate('j F Y', $value->order_date) ?></td>
                                    <td><span class="badge badge-pill badge-warning "><?php echo $payment_data[0]['payment_method'] ?></span></td>
                                    <td>
                                        <a href="javascript:modalDetailOrder(<?php echo $value->order_key ?>)"><span class="badge badge-pill  badge-primary ">รายละเอียด</span></a>

                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade " id="cancel" role="tabpanel" aria-labelledby="cancel-tab">
                    <h3>คำสั่งซื้อที่ยกเลิก</h3>
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">ลำดับ</th>
                                <th scope="col">รหัสออเดอร์</th>
                                <th scope="col">ราคารวม</th>
                                <th scope="col">ค่าขนส่ง</th>
                                <th scope="col">วันที่สั่งซื้อ</th>
                                <th scope="col">การชำระเงิน</th>
                                <th scope="col">รายละเอียด</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            $detail_i  = 1;
                            foreach ($Orderscancel as $key => $value) :
                                $payment_OrdersOrderscancel = new Payments();
                                $payment_data = $payment_OrdersOrderscancel->getShowPaymentsAllKey('order_key', $value->order_key, PDO::FETCH_ASSOC) ?? [['payment_method' => 'รอชำระเงิน']];
                                // $detail->getShowOrderDetailsOne($value->order_key)
                                // var_dump($payment_data);

                            ?>
                                <tr class="text-left">
                                    <th scope="row" class="text-center"><?php echo  $detail_i++; ?></th>
                                    <td><?php echo $value->order_code ?></td>
                                    <td>฿<?php echo $value->order_price ?>.00</td>
                                    <td>฿<?php echo $value->order_price_delivery ?>.00</td>
                                    <td><?php echo thaidate('j F Y', $value->order_date) ?></td>
                                    <td><span class="badge badge-pill badge-warning "><?php echo $payment_data[0]['payment_method'] ?></span></td>
                                    <td>
                                        <a href="javascript:modalDetailOrder(<?php echo $value->order_key ?>)"><span class="badge badge-pill  badge-primary ">รายละเอียด</span></a>

                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <?php include_once __DIR__ . '/./layouts/footer.php' ?>



</body>

</html>