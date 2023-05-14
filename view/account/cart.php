<?php include_once __DIR__ . '/./layouts/top_head.php' ?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->

    <meta name="author" content="CodePixar">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>ตะกร้าสินค้า - <?php echo $_ENV['APP_NAME'] ?></title>


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
                    <h1>ตะกร้าสินค้า</h1>
                    <nav class="d-flex align-items-center">
                        <a href="./index.php">หน้าหลัก<span class="lnr lnr-arrow-right"></span></a>
                        <a href="./cart.php">Cart</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->


    <script>
        function add_item(product_key, item, index) {

            // alert(product_key + item + index);
            if (item == 0) {
                del_items(index);
            } else {
                var int_i = 0;
                var product = [];
                var num_item_new = parseInt(item);

                product = JSON.parse(readCookie('product')); // array type
                product.forEach(function(value, i) {
                    // alert(i);
                    if (value.product_key == product_key) {
                        int_i += 1;
                        product[i].ordetail_item = num_item_new;
                    }
                });

                createCookie("product", JSON.stringify(product));
                product_item_all()

                successSwal('อัพเดทสินค้าลงตะกร้าสำเร็จ', false)

            }

        }

        function add_item_btn(product_key, item, index) {
            var item = item.value;
            // alert(index + item + product_key)
            add_item(product_key, item, index);
        }


        function product_item_all() {
            var tbody = "";

            const json = readCookie('product');
            const product = JSON.parse(json);

            console.log(json);
            var sum_total = 0;

            $('#tbb_product_item_all').empty();

            product.forEach(function(value, index) {

                let id_input = 'sst_' + value.product_key;
                let total = value.ordetail_item * value.product_price;
                sum_total += total;

                tbody += `
                        <tr>
                            <td>
                                    <div class="media">
                                        <div class="d-flex">
                                            <img style="width: 100px;" src="./../assets/images/products/${value.product_picture}" alt="">
                                        </div>
                                        <div class="media-body">
                                            <p>${value.product_name}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5>฿${value.product_price}.00</h5>
                                </td>
                                <td>
                                    <div class="product_count">
                                        <input type="text" name="qty" onchange="add_item(${value.product_key}, this.value, ${index})" id="${id_input}" maxlength="12" value="${value.ordetail_item}" title="Quantity:" class="input-text qty">
                                        <button onclick="var result = document.getElementById('${id_input}'); var sst = result.value; if( !isNaN( sst )) result.value++;add_item_btn(${value.product_key},${id_input}, ${index} );return false;" class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                                        <button onclick="var result = document.getElementById('${id_input}'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;add_item_btn(${value.product_key},${id_input}, ${index} );return false;  " class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                                        
                                    </div>
                                </td>
                            <td>
                                <h5>${THB.format(total)}</h5>
                            </td>
                        </tr>`;

                // $tbody += '<tr><td class="pro-thumbnail"><a href="#"><img width="350" height="350"src="assets/images/products/product01.webp" class="img-fluid" alt="Product"></a></td><td class="pro-title"><a href="#">สินค้ารายการที่ 1 สินค้ารายการที่ 1</a></td><td class="pro-price"><span>฿29.00</span></td><td class="pro-quantity"><div class="pro-qty"><input type="text" value="1"></div></td><td class="pro-subtotal"><span>฿29.00</span></td><td class="pro-remove"><a href="#"><i class="fa fa-trash-o"></i></a></td></tr>';
            });

            if (product == '') {
                $("#div-product").html('<h4>ตะกร้าสินค้าของคุณ ไม่มีสินค้า <a href="./category.php">คลิ๊กเพื่อไปยังหน้ารายการสินค้า</a></h4>');
                // $("# ").css('display', 'none');
            }

            $(".sum_totallist").html(THB.format(sum_total));
            $('#tbb_product_item_all').html(tbody);

        }

        

        function onch() {
            alert('Please')
        }
    </script>

    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th scope="col">ภาพ</th>
                                <th scope="col">ราคา</th>
                                <th scope="col">จำนวน</th>
                                <th scope="col">รวม</th>
                            </tr>
                        </thead>
                        <tbody id="tbb_product_item_all">

                        </tbody>
                        <tbody>
                            <tr class="bottom_button">
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <h5>ยอดรวม</h5>
                                </td>
                                <td>
                                    <h5 class="sum_totallist"></h5>
                                </td>
                            </tr>

                            <tr class="out_button_area ">
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <div class="checkout_btn_inner d-flex align-items-end mr-0">
                                        <a class="gray_btn" href="./category.php">ช้อปปิ้งต่อ</a>
                                        <a class="primary-btn" href="./checkout.php">ดำเนินการชำระเงิน</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script>
        window.onload = function() {
            product_item_all()
        };
    </script>
    <!--================End Cart Area =================-->
    <?php include_once __DIR__ . '/./layouts/footer.php' ?>


</body>

</html>