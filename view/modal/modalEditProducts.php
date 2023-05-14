<?php

date_default_timezone_set('Asia/Bangkok');

require_once __DIR__ . '/../../App/config/connectdb.php';
// require_once __DIR__ . '/../../App/models/Orders.php';
// require_once __DIR__ . '/../../App/models/Payments.php';
// require_once __DIR__ . '/../../App/models/OrdersDetails.php';
require_once __DIR__ . '/../../App/models/Products.php';
// require_once __DIR__ . '/../../App/models/Accounts.php';
// require_once __DIR__ . '/../../App/models/productss.php';
// require_once __DIR__ . '/../../App/models/RelationCardProducts.php';


// if (!isset($_POST['action'])) {
//     return false;
// }

$product_key = isset($_POST['product_key']) ? $_POST['product_key'] : false;

if (!$product_key) {
    return false;
}
$products = new Products();
$products->getShowProductsOne($product_key);


// $relationCard = new  RelationCardProducts();
// $relationCardData = $relationCard->getShowRelationCardProductsCardAllKey('product_key', $product_key);



?>

<div class="modal fade" id="editProducts" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="editProducts_form" action="javascript:void(0)" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="">แก้ไขการ์ด</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                    </div>
                    <div class="row p-2" novalidate="novalidate">
                        
                        <div class="col-4">
                            <img id="showEditProduc" width="100%" src="./../assets/images/products/<?php echo $products->getProduct_picture() ?>" alt="">
                        </div>
                        <div class="col-8">
                            <div class="row login_form" style="  margin-right: 0px; padding :0px;">
                                <input type="hidden" name="product_key_EditTaro" value="<?php echo $product_key ?>">
                                <div class="col-md-12 form-group">
                                    <input id="card_picture_EditTaro" type="hidden" value="<?php echo $products->getProduct_picture() ?>" class="form-control" name="card_picture_EditTaro" placeholder="เลือกรูปภาพ" onfocus="this.placeholder = ''" onblur="this.placeholder = 'เลือกรูปภาพ'">
                                    <input id="input_image_EditProduct" type="file" class="form-control" placeholder="เลือกรูปภาพ" accept="image/*" onfocus="this.placeholder = ''" onblur="this.placeholder = 'เลือกรูปภาพ'">
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" name="card_name_EditTaro" placeholder="ชื่อสินค้า" onfocus="this.placeholder = ''" onblur="this.placeholder = 'ชื่อสินค้า'" value="<?php echo $products->getProduct_name() ?>">
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="number" class="form-control" name="card_name_EditTaro" placeholder="จำนวนคงเหลือ" onfocus="this.placeholder = ''" onblur="this.placeholder = 'จำนวนคงเหลือ'" value="<?php echo $products->getProduct_name() ?>">
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="number" class="form-control" name="card_name_EditTaro" placeholder="ราคา" onfocus="this.placeholder = ''" onblur="this.placeholder = 'ราคา'" value="<?php echo $products->getProduct_name() ?>">
                                </div>

                                <div class="col-md-12 form-group">
                                    <textarea class="form-control" name="card_detail_EditTaro" rows="5" placeholder="รายละเอียด"><?php echo $products->getProduct_detail() ?></textarea>
                                </div>
                            </div>
                        </div>


                    </div>
                    <script>
                        // get a reference to the file input
                        const showEditProducx = document.querySelector("img[id=showEditProduc]");
                        // get a reference to the file input
                        const fileInput_EditTaroCart = document.querySelector("input[id=input_image_EditProduct]");

                        // listen for the change event so we can capture the file
                        fileInput_EditTaroCart.addEventListener("change", (e) => {
                            let canvas;

                            let base64StringImg_EditTaro_show = null;

                            // get a reference to the file
                            const file = e.target.files[0];

                            const reader = new FileReader();
                            reader.onloadend = (e) => {
                                let img = document.createElement("img");
                                img.onload = function(event) {
                                    // Dynamically create a canvas element
                                    let canvas = document.createElement("canvas");
                                    canvas.width = 600;
                                    canvas.height = 900;
                                    // let canvas = document.getElementById("canvas");
                                    let ctx = canvas.getContext("2d");
                                    // Actual resizing
                                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                                    let dataurl = canvas.toDataURL(file.type);  
                                    showEditProducx.src = dataurl;
                                    const base64String_ = dataurl
                                        .replace("data:", "")
                                        .replace(/^.+,/, "");
                                    base64StringImg_EditTaro_show = base64String_;

                                    $("#card_picture_EditTaro").val(base64StringImg_EditTaro_show);
                                    // console.log(base64StringImg_EditTaro_show);
                                }
                                img.src = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        });
                    </script>

                    <div class="row">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">แก้ไขข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#editProducts_form").submit(function(e) {
        // console.log(e);
        let inputs = $("#editProducts_form :input");
        let data_edit = {};
        inputs.each(function() {
            data_edit[this.name] = $(this).val();
        });
        console.log(data_edit);

        $.ajax({
            url: "./../../App/controllers/productssController.php",
            type: "POST",
            data: {
                action: "editProducts_form",
                data: data_edit
            },
            success: function(response) {
                // console.log(response);
                const {
                    msg,
                    message
                } = response ?? {};
                if (msg === "success") {
                    successSwal(message, true);
                } else {
                    errorSwal(message, false);
                }
            },
            error: function() {
                errorSwal("ระบบตรวจพบข้อผิดจากระบบ!", false);
                // console.log("Error: " + textStatus + " - " + errorThrown);
                // console.error(jqXHR)
            }
        });

    });
</script>