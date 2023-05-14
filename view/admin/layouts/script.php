<script src="./../assets/lib/jQuery/jquery.min.js"></script>
<script src="./../assets/js/vendor/jquery-2.2.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="./../assets/js/vendor/bootstrap.min.js"></script>
<script src="./../assets/js/jquery.ajaxchimp.min.js"></script>
<script src="./../assets/js/jquery.nice-select.min.js"></script>
<script src="./../assets/js/jquery.sticky.js"></script>
<script src="./../assets/js/nouislider.min.js"></script>
<script src="./../assets/js/jquery.magnific-popup.min.js"></script>
<script src="./../assets/js/owl.carousel.min.js"></script>
<!--gmaps Js-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
<script src="./../assets/js/gmaps.min.js"></script>
<script src="./../assets/js/main.js"></script>
<script src="./../assets/js/main_add.js"></script>
<script src="./../assets/js/sweetalert2@11.js"></script>

<!-- <link rel="stylesheet" href="./../assets/lib/dataTable/datatables.min.css">
<script type="text/javascript" charset="utf8" src="./../assets/lib/dataTable/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="./../assets/lib/dataTable/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="./../assets/lib/dataTable/datatables.min.js"></script> -->




<script>
    // const submitCart = () => {
    //     addCartProduct()
    // }
    $(document).ready(function() {
        var product = [];
        if (readCookie('product') == null) {
            createCookie("product", JSON.stringify(product));

        }

    });
    //--------------------------------------------------------------------------------------------------------------------
    /// funtion Product
    const deleteProductButton = (product_key) => {
        let data = {
            "product_key": product_key
        };

        Swal.fire({
            icon: 'error',
            title: 'คุณแน่ใจว่าต้องการลบ',
            text: "คุณจะเปลี่ยนกลับไม่ได้!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่',
            cancelButtonText: 'ปิด'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "./../../App/controllers/ProductsController.php",
                    type: "POST",
                    // dataType: "json",
                    data: {
                        action: "deleteProductButton",
                        data: data,

                    },
                    success: function(response, statusText, jqXHR) {
                        console.log(response);
                        const {
                            msg,
                            message
                        } = response ?? {};

                        if (msg === "success") {
                            successSwal(message, true)
                        } else {
                            errorSwal(message, false);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        errorSwal("ระบบตรวจพบข้อผิดจากระบบ!", false);
                        console.log("Error: " + textStatus + " - " + errorThrown);
                    },
                });
            }
        })
    };

    const modalShowEditProduct = (product_key ) => {
        // alert(card_key)
        $.ajax({
            url: "./../modal/modalEditProducts.php",
            type: "POST",
            // dataType: "json",
            data: {
                action: "modalShowEditProduct",
                product_key : product_key ,
            },
            success: function(response, statusText, jqXHR) {
                console.log(response);
                $("#show-modal").html(response);
                $("#editProducts").modal("show");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                errorSwal("ระบบตรวจพบข้อผิดจากระบบ!", false);
                console.log("Error: " + textStatus + " - " + errorThrown);
            },
        });
    }

    //--------------------------------------------------------------------------------------------------------------------

    // modalShowEditProduct
    const modalEditTaroCards = (card_key) => {
        // alert(card_key)
        $.ajax({
            url: "./../modal/modalEditTaroCards.php",
            type: "POST",
            // dataType: "json",
            data: {
                action: "modalEditTaroCards",
                card_key: card_key,
            },
            success: function(response, statusText, jqXHR) {
                console.log(response);
                $("#show-modal").html(response);
                $("#editTarotcards").modal("show");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                errorSwal("ระบบตรวจพบข้อผิดจากระบบ!", false);
                console.log("Error: " + textStatus + " - " + errorThrown);
            },
        });
    }


    // modalEditProducts.php
    
    const deleteCardButton = (card_key) => {
        let data = {
            "card_key": card_key
        };

        Swal.fire({
            icon: 'error',
            title: 'คุณแน่ใจว่าต้องการลบ',
            text: "คุณจะเปลี่ยนกลับไม่ได้!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่',
            cancelButtonText: 'ปิด'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "./../../App/controllers/TarotCardsController.php",
                    type: "POST",
                    // dataType: "json",
                    data: {
                        action: "deleteCardButton",
                        data: data,

                    },
                    success: function(response, statusText, jqXHR) {
                        // console.log(response);
                        const {
                            msg,
                            message
                        } = response ?? {};

                        if (msg === "success") {
                            successSwal(message, true)
                        } else {
                            errorSwal(message, false);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        errorSwal("ระบบตรวจพบข้อผิดจากระบบ!", false);
                        console.log("Error: " + textStatus + " - " + errorThrown);
                    },
                });
            }
        })
    };

    const addRelationCardButton = (product_key, card_key) => {
        let data = {
            "product_key": product_key,
            "card_key": card_key,
        };

        Swal.fire({
            icon: 'error',
            title: 'คุณแน่ใจว่าต้องการเพิ่ม',
            text: "คุณจะเปลี่ยนกลับไม่ได้!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่',
            cancelButtonText: 'ปิด'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "./../../App/controllers/RelationCardProductController.php",
                    type: "POST",
                    // dataType: "json",
                    data: {
                        action: "addRelationCardButton",
                        data: data,

                    },
                    success: function(response, statusText, jqXHR) {
                        // console.log(response);
                        const {
                            msg,
                            message
                        } = response ?? {};

                        if (msg === "success") {
                            successSwal(message, false)
                        } else {
                            errorSwal(message, false);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        errorSwal("ระบบตรวจพบข้อผิดจากระบบ!", false);
                        console.log("Error: " + textStatus + " - " + errorThrown);
                    },
                });
            }
        })
    };

    const deletRelationCardButton = (relation_key) => {
        let data = {
            "relation_key": relation_key
        };

        Swal.fire({
            icon: 'error',
            title: 'คุณแน่ใจว่าจะลบ',
            text: "คุณจะเปลี่ยนกลับไม่ได้!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่',
            cancelButtonText: 'ปิด'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "./../../App/controllers/RelationCardProductController.php",
                    type: "POST",
                    // dataType: "json",
                    data: {
                        action: "deletRelationCardButton",
                        data: data,

                    },
                    success: function(response, statusText, jqXHR) {
                        // console.log(response);
                        const {
                            msg,
                            message
                        } = response ?? {};

                        if (msg === "success") {
                            successSwal(message, true)
                        } else {
                            errorSwal(message, false);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        errorSwal("ระบบตรวจพบข้อผิดจากระบบ!", false);
                        console.log("Error: " + textStatus + " - " + errorThrown);
                    },
                });
            }
        })
    };

    


    const modalDetailOrder = (order_key) => {
        // alert(order_key)
        $.ajax({
            url: "./../modal/modalDetailOrder.php",
            type: "POST",
            // dataType: "json",
            data: {
                action: "modalDetailOrder",
                order_key: order_key,
            },
            success: function(response, statusText, jqXHR) {
                // console.log(response);
                $("#show-modal").html(response);
                $("#showDetailOrder").modal("show");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                errorSwal("ระบบตรวจพบข้อผิดจากระบบ!", false);
                console.log("Error: " + textStatus + " - " + errorThrown);
            },
        });
    }


    let THB = Intl.NumberFormat("th-TH", {
        style: "currency",
        currency: "THB",
    });


    const confirmOrderButton = (order_key) => {
        let data = {
            "order_key": order_key
        };
        Swal.fire({
            icon: 'warning',
            title: 'ต้องการยืนยันคำสั่งซื้อ',
            text: "คุณจะเปลี่ยนกลับไม่ได้!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ปิด'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "./../../App/controllers/OrdersController.php",
                    type: "POST",
                    // dataType: "json",
                    data: {
                        action: "confirmOrderButton",
                        data: data,

                    },
                    success: function(response, statusText, jqXHR) {
                        // console.log(response);
                        const {
                            msg,
                            message
                        } = response ?? {};

                        if (msg === "success") {
                            successSwal(message, true)
                        } else {
                            errorSwal(message, false);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        errorSwal("ระบบตรวจพบข้อผิดจากระบบ!", false);
                        console.log("Error: " + textStatus + " - " + errorThrown);
                    },
                });
            }
        })
    }

    const pickUpOrderButton = (order_key) => {
        let data = {
            "order_key": order_key
        };
        Swal.fire({
            icon: 'warning',
            title: 'คุณแน่ใจว่าได้รับสินค้าแล้ว',
            text: "คุณจะเปลี่ยนกลับไม่ได้!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ปิด'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "./../../App/controllers/OrdersController.php",
                    type: "POST",
                    // dataType: "json",
                    data: {
                        action: "pickUpOrderButton",
                        data: data,

                    },
                    success: function(response, statusText, jqXHR) {
                        // console.log(response);
                        const {
                            msg,
                            message
                        } = response ?? {};

                        if (msg === "success") {
                            successSwal(message, true)
                        } else {
                            errorSwal(message, false);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        errorSwal("ระบบตรวจพบข้อผิดจากระบบ!", false);
                        console.log("Error: " + textStatus + " - " + errorThrown);
                    },
                });
            }
        })
    }

    const cancelOrderButton = (order_key) => {
        let data = {
            "order_key": order_key
        };

        Swal.fire({
            icon: 'error',
            title: 'คุณแน่ใจว่าจะยกเลิก',
            text: "คุณจะเปลี่ยนกลับไม่ได้!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่',
            cancelButtonText: 'ปิด'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "./../../App/controllers/OrdersController.php",
                    type: "POST",
                    // dataType: "json",
                    data: {
                        action: "cancelOrderButton",
                        data: data,

                    },
                    success: function(response, statusText, jqXHR) {
                        // console.log(response);
                        const {
                            msg,
                            message
                        } = response ?? {};

                        if (msg === "success") {
                            successSwal(message, true)
                        } else {
                            errorSwal(message, false);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        errorSwal("ระบบตรวจพบข้อผิดจากระบบ!", false);
                        console.log("Error: " + textStatus + " - " + errorThrown);
                    },
                });
            }
        })



    };






    function createCookie(name, value, days = 1) { // date /1 วัน
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    }


    function readCookie(name) {
        var name1 = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1, c.length);
            }
            if (c.indexOf(name1) == 0) {
                return c.substring(name1.length, c.length);
            }
        }
        return null;
    }

    function removeCookie(name) {
        createCookie(name, "", -1);
    }


    function addCartProduct(product_key, product_price, product_name, product_picture, idInPutValue) {


        // console.log('Add Product');
        let product = [];
        let int_i = 0;
        let idInPutValue_new = parseInt($("#" + idInPutValue).val());

        // alert($("#"+idInPutValue).val());

        product_new = {
            product_key: product_key,
            product_price: product_price,
            ordetail_item: idInPutValue_new,
            product_name: product_name,
            product_picture: product_picture
        };

        if (readCookie('product') == null) {
            createCookie("product", JSON.stringify(product));

            product.push(product_new);
            createCookie("product", JSON.stringify(product));

        } else {
            product = JSON.parse(readCookie('product')); // array type

            product.forEach(function(value, i) {
                if (value.product_key == product_key) {
                    int_i += 1;
                    if (idInPutValue_new < 50) {
                        product[i].ordetail_item += idInPutValue_new;
                    } else {
                        product[i].ordetail_item = idInPutValue_new;
                    }

                }
            });

            if (int_i == 0) {
                product.push(product_new);
                createCookie("product", JSON.stringify(product));


            } else {
                createCookie("product", JSON.stringify(product));

            }

        }
        successSwal('เพิ่มสินค้าลงตะกร้าสำเร็จ', false)

        // $("#" + idInPutValue).val(1);
    }


    function del_items(index) {

        const json = readCookie('product');
        const product = JSON.parse(json);
        product.splice(index, 1);
        createCookie("product", JSON.stringify(product));

        try {
            product_item_all();
        } catch (Exception) {
            console.error("product_item_all_error")
        }

    }
</script>