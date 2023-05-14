<?php

date_default_timezone_set('Asia/Bangkok');

require_once __DIR__ . '/../../App/config/connectdb.php';
// require_once __DIR__ . '/../../App/models/Orders.php';
// require_once __DIR__ . '/../../App/models/Payments.php';
// require_once __DIR__ . '/../../App/models/OrdersDetails.php';
require_once __DIR__ . '/../../App/models/Products.php';
// require_once __DIR__ . '/../../App/models/Accounts.php';
require_once __DIR__ . '/../../App/models/TarotCards.php';
require_once __DIR__ . '/../../App/models/RelationCardProducts.php';


// if (!isset($_POST['action'])) {
//     return false;
// }

$card_key = isset($_POST['card_key']) ? $_POST['card_key'] : false;

if (!$card_key) {
    return false;
}
$tarotCard = new TarotCards();
$tarotCard->getShowTarotCardsOne($card_key);


$relationCard = new  RelationCardProducts();
$relationCardData = $relationCard->getShowRelationCardProductsCardAllKey('card_key', $card_key);



?>

<div class="modal fade" id="editTarotcards" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="editTarotcards_form" action="javascript:void(0)" method="post">
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
                            <img id="showEditTaro" width="100%" src="./../assets/images/tarotcards/<?php echo $tarotCard->getCard_picture() ?>" alt="">
                        </div>
                        <div class="col-8">
                            <div class="row login_form" style="  margin-right: 0px; padding :0px;">
                                <input type="hidden" name="card_key_EditTaro" value="<?php echo $card_key ?>">
                                <div class="col-md-12 form-group">
                                    <input id="card_picture_EditTaro" type="hidden" value="<?php echo $tarotCard->getCard_picture() ?>" class="form-control" name="card_picture_EditTaro" placeholder="เลือกรูปภาพ" onfocus="this.placeholder = ''" onblur="this.placeholder = 'เลือกรูปภาพ'">
                                    <input id="input_image_EditTaro" type="file" class="form-control" placeholder="เลือกรูปภาพ" accept="image/*" onfocus="this.placeholder = ''" onblur="this.placeholder = 'เลือกรูปภาพ'">
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" name="card_name_EditTaro" placeholder="ชื่อการ์ด" onfocus="this.placeholder = ''" onblur="this.placeholder = 'ชื่อการ์ด'" value="<?php echo $tarotCard->getCard_name() ?>">
                                </div>
                                <div class="col-md-12 form-group">
                                    <textarea class="form-control" name="card_meaning_EditTaro" rows="5" placeholder="ความหมายไพ่"><?php echo $tarotCard->getCard_meaning() ?></textarea>
                                </div>
                                <div class="col-md-12 form-group">
                                    <textarea class="form-control" name="card_detail_EditTaro" rows="5" placeholder="รายละเอียดไพ่"><?php echo $tarotCard->getCard_detail() ?></textarea>
                                </div>
                            </div>
                        </div>


                    </div>
                    <script>
                        // get a reference to the file input
                        const showEditTarox = document.querySelector("img[id=showEditTaro]");
                        // get a reference to the file input
                        const fileInput_EditTaroCart = document.querySelector("input[id=input_image_EditTaro]");

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
                                    showEditTarox.src = dataurl;
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
                        <div class="col align-items-start">
                            <h5>เพิ่มสินค้า</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ลำดับ</th>
                                        <th scope="col">ชื่อการ์ด</th>
                                        <th scope="col">เพิ่ม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $productTabel = new  Products();
                                    $productTabel = $productTabel->getShowProductsAll();


                                    $ii = 1;
                                    foreach ($productTabel as $key => $value) :
                                        $produc_ra = new Products();
                                        $produc_ra->getShowProductsOne($value->product_key)
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $ii++; ?></th>
                                            <td><?php echo  $produc_ra->getProduct_name() ?></td>
                                            <td><a href="javascript:addRelationCardButton(<?php echo $value->product_key ?>,<?php echo  $card_key ?>)">เพิ่ม</a></td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col align-items-end">
                            <h5>รายการสินค้า</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ลำดับ</th>
                                        <th scope="col">ชื่อการ์ด</th>
                                        <th scope="col">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $ii = 1;
                                    foreach ($relationCardData as $key => $value) :
                                        $produc_ra = new Products();
                                        $produc_ra->getShowProductsOne($value->product_key)
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $ii++; ?></th>
                                            <td><?php echo  $produc_ra->getProduct_name() ?></td>
                                            <td><a href="javascript:deletRelationCardButton(<?php echo $value->relation_key ?>)">ลบ</a></td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
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
    $("#editTarotcards_form").submit(function(e) {
        // console.log(e);
        let inputs = $("#editTarotcards_form :input");
        let data_edit = {};
        inputs.each(function() {
            data_edit[this.name] = $(this).val();
        });
        console.log(data_edit);

        $.ajax({
            url: "./../../App/controllers/TarotCardsController.php",
            type: "POST",
            data: {
                action: "editTarotcards_form",
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