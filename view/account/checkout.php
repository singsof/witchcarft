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
    <title>ชำระสินค้า - <?php echo $_ENV['APP_NAME'] ?></title>


    <?php include_once __DIR__ . '/./layouts/header.php' ?>
    <?php include_once __DIR__ . '/./layouts/script.php' ?>
</head>

<body>
    <!-- Modal -->

    <div id="show-modal"></div>
    <?php include_once __DIR__ . '/layouts/navbar.php' ?>
    <!-- start banner Area -->
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>ชำระสินค้า</h1>
                    <nav class="d-flex align-items-center">
                        <a href="./index.php">หน้าหลัก<span class="lnr lnr-arrow-right"></span></a>
                        <a href="./cart.php">checkout </a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
    <!-- End Banner Area -->



    <!--================Checkout Area =================-->
    <section class="checkout_area section_gap">
        <div class="container">
            <form id="form-order" action="javascript:void(0)" method="post">
                <input type="hidden" name="account_id" value="<?php echo $_Account->getAccount_id() ?>">
                <input type="hidden" name="order_price" value="">
                <input type="hidden" name="order_price_delivery" value="50">
                <div class="billing_details">
                    <div class="row">
                        <div class="col-lg-8">
                            <h3>รายละเอียดการเรียกเก็บเงิน</h3>
                            <div class="row contact_form" novalidate="novalidate">
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="first" name="account_name" value="<?php echo $_Account->getAccount_name() ?>" disabled>

                                </div>

                                <div class="col-md-6 form-group p_star">
                                    <input type="text" class="form-control" id="number" name="account_phone" value="<?php echo $_Account->getAccount_phone() ?>" disabled>

                                </div>
                                <div class="col-md-6 form-group p_star">
                                    <input type="text" class="form-control" id="email" name="account_email" value="<?php echo $_Account->getAccount_email() ?>" disabled>

                                </div>

                                <div class="col-md-12 form-group">
                                    <div class="creat_account">
                                        <h3>รายละเอียดการจัดส่ง</h3>
                                    </div>
                                    <textarea class="form-control" name="order_delivery" id="message" rows="1" placeholder="ที่อยู่จัดส่ง"><?php echo $_Account->getAccount_address() ?></textarea>
                                </div>
                            </div>
                        </div>

                        <script>
                            $(document).ready(function() {
                                tbb_product_item_all_check();
                            });

                            // $('input[name="payment_method"]').val(null)

                            var isCheckQrCode = null;

                            var sum_total = 0;
                            var sum_total_items = 0;

                            function tbb_product_item_all_check() {
                                var tbody = "";

                                const json = readCookie('product');
                                const product = JSON.parse(json);

                                // console.log(json);


                                $('#tbb_product_item_all_check').empty();

                                product.forEach(function(value, index) {

                                    tbody += `<li>
                                    <a href="javascript:void(0)">${value.product_name} <span class="middle"> x ${value.ordetail_item}</span><span class="last">${THB.format(value.ordetail_item * value.product_price)}</span>
                                    </a>
                                </li>`;
                                    // alert(tbody);
                                    sum_total += value.ordetail_item * value.product_price;
                                    sum_total_items += value.ordetail_item;
                                    // $tbody += '<tr><td class="pro-thumbnail"><a href="#"><img width="350" height="350"src="assets/images/products/product01.webp" class="img-fluid" alt="Product"></a></td><td class="pro-title"><a href="#">สินค้ารายการที่ 1 สินค้ารายการที่ 1</a></td><td class="pro-price"><span>฿29.00</span></td><td class="pro-quantity"><div class="pro-qty"><input type="text" value="1"></div></td><td class="pro-subtotal"><span>฿29.00</span></td><td class="pro-remove"><a href="#"><i class="fa fa-trash-o"></i></a></td></tr>';
                                });

                                if (product == '') {
                                    window.history.back(-1);
                                }

                                $(".sum_totallist").html(THB.format(sum_total));
                                $(".sum_totallistAll").html(THB.format(sum_total + 50));
                                $('#tbb_product_item_all_check').html(tbody);
                                $("input[name='order_price']").val(sum_total)

                            }
                        </script>
                        <div class="col-lg-4">
                            <div class="order_box">
                                <h2>คำสั่งของคุณ</h2>
                                <ul class="list">
                                    <li><a href="javascript:void(0)">สินค้า <span>Total</span></a></li>
                                </ul>
                                <ul class="list" id="tbb_product_item_all_check">

                                </ul>
                                <ul class="list list_2">
                                    <li><a href="#">ยอดรวม <span class="sum_totallist"></span></a></li>
                                    <li><a href="#">ค่าจัดส่ง <span>Flat rate: ฿50.00</span></a></li>
                                    <li><a href="#">ทั้งหมด <span class="sum_totallistAll"></span></a></li>
                                </ul>
                                <div class="payment_item">
                                    <div id="f-option55" class="radion_btn">
                                        <input type="radio" id="f-option5" name="payment_method">
                                        <label for="f-option5">ชำระปลายทาง</label>
                                        <div class="check"></div>
                                    </div>
                                </div>
                                <div class="payment_item">
                                    <div class="radion_btn">
                                        <input type="radio" id="f-option6" name="payment_method">
                                        <label for="f-option6">QrCode</label>
                                        <div class="check"></div>
                                    </div>
                                </div>


                                <div class="creat_account text-center">
                                    <img id="img_qrcode" style="display:none;" width="100%" src="./../assets/images/qrcode.jfif" alt="">
                                </div>

                                <script>
                                    $("#f-option6").on("click", function() {
                                        $("#img_qrcode").show("slow");
                                        // $(this).val('qrcode')
                                        $('input[name="payment_method"]').val('qrcode')
                                        isCheckQrCode = true

                                        // alert('lksf')
                                    });
                                    $("#f-option55").on("click", function() {
                                        $("#img_qrcode").hide("slow");
                                        $('input[name="payment_method"]').val('cash')
                                        isCheckQrCode = false

                                        // alert('lksf')
                                    });
                                </script>
                                <!-- <a class="primary-btn" href="./orderlist.php">สั่งซื้อ</a> -->
                                <button class="btn primary-btn" type="submit">สั่งซื้อ</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <script>
                $("#form-order").submit(function(e) {
                    // console.log(e);
                    let inputs = $("#form-order :input");
                    let data = {};
                    inputs.each(function() {
                        data[this.name] = $(this).val();
                    });
                    // console.log(data);
                    if (isCheckQrCode === null) {
                        errorSwal('กรุณาเลือกรูปแบบการชำระเงิน', false);
                        return false;
                    }

                    if (isCheckQrCode) {
                        let timerInterval
                        Swal.fire({
                            title: 'โปรดรอสักครู่',
                            html: 'ระบบกำลังตรวจสอบการชำระเงิน ( <b></b> ) มิลลิวินาที',
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()
                                const b = Swal.getHtmlContainer().querySelector('b')
                                timerInterval = setInterval(() => {
                                    b.textContent = Swal.getTimerLeft()
                                }, 100)
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                                // successSwal('ตรวจสอบการชำระเงินสำเร็จ', true);
                            }
                        })
                    }

                    const json = readCookie('product');
                    const product = JSON.parse(json)


                    setTimeout(function() {
                        $.ajax({
                            url: "../../App/controllers/OrdersController.php",
                            type: "POST",
                            // dataType: "json",
                            data: {
                                action: "form-order",
                                data: data,
                                product: product
                            },
                            success: function(response, statusText, jqXHR) {
                                // console.log(response);
                                const {
                                    msg,
                                    message
                                } = response ?? {};

                                if (msg === "success") {
                                    successSwal(message, './../account/orderlist.php')
                                    // removeCookie('product');
                                } else {
                                    errorSwal(message, false);
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                errorSwal("ระบบตรวจพบข้อผิดจากระบบ!", false);
                                console.log("Error: " + textStatus + " - " + errorThrown);
                                // console.error(jqXHR)
                            },
                        });
                    }, 3500); // Delay of 2000 milliseconds (2 seconds)

                });
            </script>
        </div>
    </section>

    <!--================End Checkout Area =================-->

    <?php include_once __DIR__ . '/./layouts/footer.php' ?>

</body>

</html>