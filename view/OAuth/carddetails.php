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
    <title>รายการสินค้า - <?php echo $_ENV['APP_NAME'] ?></title>

    <?php include_once __DIR__ . '/./layouts/header.php' ?>
    <?php include_once __DIR__ . '/./layouts/script.php' ?>



    <?php
    $card_key = isset($_GET["card_key"]) && $_GET["card_key"] !== '' ? $_GET["card_key"] : false;
    $tarotCard = new TarotCards();
    $tarotCard->setCard_key($card_key);

    $tarotCardData = $tarotCard->getShowTarotCardsOne($card_key) ?? false;

    if (!$card_key || !$tarotCardData) {
        header('location: ./index.php');
    }

    $relationCard = new RelationCardProducts();
    $relationCardData = $relationCard->getShowRelationCardProductsCardAllKey('card_key', $tarotCard->getCard_key());


    ?>

</head>

<body>

    <?php include_once __DIR__ . '/layouts/navbar.php' ?>
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>หน้ารายละเอียดสินค้า</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.php">หน้าหลัก<span class="lnr lnr-arrow-right"></span></a>
                        <a href="./category.php">สินค้า<span class="lnr lnr-arrow-right"></span></a>
                        <a href="่javascript:void(0)">รายละเอียดสินค้า - <?php echo $tarotCard->getCard_name() ?></a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Single Product Area =================-->
    <div class="product_image_area">
        <div class="container">
            <div class="row s_product_inner">
                <div class="col-lg-6">
                    <div class="s_Product_carousel">
                        <div class="single-prd-item">
                            <img style="height: 800px;" class="img-fluid" src="./../assets/images/tarotcards/<?php echo $tarotCard->getCard_picture() ?>" alt="">
                        </div>
                        <div class="single-prd-item">
                            <img style="height: 800px;" class="img-fluid" src="./../assets/images/tarotcards/<?php echo $tarotCard->getCard_picture() ?>" alt="">
                        </div>
                        <div class="single-prd-item">
                            <img style="height: 800px;" class="img-fluid" src="./../assets/images/tarotcards/<?php echo $tarotCard->getCard_picture() ?>" alt="">
                        </div>

                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <div class="s_product_text">
                        <h3>ชื่อการ์ด : <?php echo $tarotCard->getCard_name() ?></h3>
                        <p><?php echo $tarotCard->getCard_meaning() ?></p>
                    </div>
                    <div class="s_product_text">
                        <h3>ความหมาย</h3>
                        <p><?php echo $tarotCard->getCard_detail() ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================End Single Product Area =================-->

    <!--================Product Description Area =================-->
    <section class="product_description_area">
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link show active " id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="true">สินค้าชิ้นไดที่เหมาะกับคุณ</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <h3 class="p-4">ไปยังหน้ารายการสินค้า <a href="./category.php">คลิก</a></h3>
                    <div class="row">
                        <?php
                        // relationCardData
                        // $productList = new RelationCardProducts();
                        // var_dump($relationCardData);
                        foreach ($relationCardData as $key => $values) :
                            $productData = new Products();
                            $productData->getShowProductsOne($values->product_key);
                        ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="single-product">
                                    <img class="img-fluid" width="33%" height="250px" src="./../assets/images/products/<?php echo $productData->getProduct_picture(); ?>" alt="<?php echo $productData->getProduct_detail() ?>">
                                    <div class="product-details">
                                        <h6><?php echo $productData->getProduct_name(); ?></h6>
                                        <div class="price">
                                            <h6>$<?php echo $productData->getProduct_price(); ?></h6>
                                        </div>
                                        <div class="prd-bottom">
                                            <input id="idInPutValue" type="hidden" value='1'>
                                            <a href="javascript:addCartProduct('<?php echo $productData->getProduct_key() ?>', '<?php echo $productData->getProduct_price() ?>', '<?php echo $productData->getProduct_name() ?>', '<?php echo $productData->getProduct_picture() ?>','idInPutValue')" class="social-info">
                                                <span class="ti-bag"></span>
                                                <p class="hover-text">เพิ่มใส่ตะกร้า</p>
                                            </a>
                                            <a href="./single-product.php?id=<?php echo $productData->getProduct_key() ?>" class="social-info">
                                                <span class="lnr lnr-move"></span>
                                                <p class="hover-text">แสดงรายละเอียด</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>
                </div>
                <?php if ($relationCardData === array()) : ?>

                    <h3 class="mb-5 mt-5">ไม่พบข้อมูลรายการสินค้า</h3>

                <?php endif; ?>
            </div>
        </div>
        </div>
    </section>
    <?php include_once __DIR__ . '/./layouts/footer.php' ?>



</body>

</html>