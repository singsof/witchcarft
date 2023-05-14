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
    <title>จัดการการ์ด - <?php echo $_ENV['APP_NAME'] ?></title>


    <?php include_once __DIR__ . '/./layouts/header.php' ?>
    <?php include_once __DIR__ . '/./layouts/script.php' ?>



    <?php

    $tarotCard = new TarotCards();
    $tarotCardData  = $tarotCard->getSelectTarotCards(sprintf("card_status = 'show' OR card_status = 'hide'"));



    ?>

</head>

<body>

    <?php include_once __DIR__ . '/layouts/navbar.php' ?>
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>จัดการการ์ด</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.php">หน้าหลัก<span class="lnr lnr-arrow-right"></span></a>
                        <a href="่javascript:void(0)">จัดการการ์ด</a>
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


            <h3>จัดการการ์ด</h3>
            <table class="table table-hover">
                <thead>
                    <tr class="text-center">
                        <th>ลำดับ</th>
                        <th scope="col">ภาพ</th>
                        <th scope="col">ชื่อการ์ด</th>
                        <th scope="col"><a onclick="$('#addTarotcards').modal('show');" href="javascript:void(0)"><span class="badge badge-primary">เพิ่ม</span></a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    // print_r($tarotCardData);
                    $i = 1;
                    foreach ($tarotCardData as $key => $value) :

                    ?>
                        <tr class="text-center">
                            <th scope="col"><?php echo $i++; ?></th>
                            <td><img src="./../assets/images/tarotcards/<?php echo  $value->card_picture ?>" width="50px" alt=""></td>
                            <td><?php echo  $value->card_name ?></td>
                            <td>
                                <a href="javascript:modalEditTaroCards(<?php echo $value->card_key ?>)"><span class="badge badge-warning">แก้ไข</span></a>
                                <a href="javascript:deleteCardButton(<?php echo $value->card_key ?>)"><span class="badge badge-danger">ลบ</span></a>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="addTarotcards" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="addTarotcards-form" action="javascript:void()" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">เพิ่มการ์ด</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row login_form" novalidate="novalidate">
                            <div class="col-md-12 form-group">
                                <input id="card_picture" type="hidden" class="form-control" name="card_picture" placeholder="เลือกรูปภาพ" onfocus="this.placeholder = ''" onblur="this.placeholder = 'เลือกรูปภาพ'">
                                <input id="input_image" type="file" class="form-control" placeholder="เลือกรูปภาพ" accept="image/*" onfocus="this.placeholder = ''" onblur="this.placeholder = 'เลือกรูปภาพ'">
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" name="card_name" placeholder="ชื่อการ์ด" onfocus="this.placeholder = ''" onblur="this.placeholder = 'ชื่อการ์ด'">
                            </div>
                            <div class="col-md-12 form-group">
                                <textarea class="form-control" name="card_meaning" id="card_meaning" rows="5" placeholder="ความหมายไพ่"></textarea>
                            </div>
                            <div class="col-md-12 form-group">
                                <textarea class="form-control" name="card_detail" id="card_detail" rows="5" placeholder="รายละเอียดไพ่"></textarea>
                            </div>
                        </div>
                        <script>
                            // get a reference to the file input
                            // const imageElement = document.querySelector("img[id=img_show]");
                            let base64StringImg_show = null;
                            // get a reference to the file input
                            const fileInput = document.querySelector("input[id=input_image]");

                            let canvas;
                            // listen for the change event so we can capture the file
                            fileInput.addEventListener("change", (e) => {
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

                                        // Show resized image in preview element
                                        let dataurl = canvas.toDataURL(file.type);
                                        // document.getElementById("preview").src = dataurl;
                                        // imageElement.src = dataurl;

                                        // console.log(dataurl.replace(/^data:image\/(png|jpg);base64,/, ""));
                                        const base64String_ = dataurl
                                            .replace("data:", "")
                                            .replace(/^.+,/, "");
                                        base64StringImg_show = base64String_;

                                        $("#card_picture").val(base64StringImg_show);
                                        // console.log(base64StringImg_show);
                                    }
                                    img.src = e.target.result;
                                };
                                reader.readAsDataURL(file);
                            });
                        </script>
                    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary">เพิ่มการ์ด</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $("#addTarotcards-form").submit(function(e) {
            // console.log(e);
            let inputs = $("#addTarotcards-form :input");
            let data = {};
            inputs.each(function() {
                data[this.name] = $(this).val();
            });
            console.log(data);

            $.ajax({
                url: "./../../App/controllers/TarotCardsController.php",
                type: "POST",
                // dataType: "json",
                data: {
                    action: "addTarotcards-form",
                    data: data,

                },
                success: function(response, statusText, jqXHR) {
                    console.log(response);
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
                error: function(jqXHR, textStatus, errorThrown) {
                    errorSwal("ระบบตรวจพบข้อผิดจากระบบ!", false);
                    console.log("Error: " + textStatus + " - " + errorThrown);
                    // console.error(jqXHR)
                },
            });

        });
    </script>


    <?php include_once __DIR__ . '/./layouts/footer.php' ?>



</body>

</html>