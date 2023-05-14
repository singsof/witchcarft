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
    <title>รายละเอียด - <?php echo $_ENV['APP_NAME'] ?></title>


	<?php include_once __DIR__ . '/./layouts/header.php' ?>
	<?php include_once __DIR__ . '/./layouts/script.php' ?>



	<?php
	$product_key = isset($_GET["id"]) && $_GET["id"] !== '' ? $_GET["id"] : false;
	$products = new Products();
	$products->setProduct_key($product_key);

	$productsData = $products->getShowProductsOne($product_key) ?? false;

	if (!$product_key || !$productsData) {
		header('location: ./category.php');
	}

	$comment = new Comments();
	$commentData = $comment->getShowCommentsCardAllKey(null, $products->getProduct_key());


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
						<a href="่javascript:void(0)">รายละเอียดสินค้า - <?php echo $products->getProduct_name() ?></a>
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
							<img class="img-fluid" src="./../assets/images/products/<?php echo $products->getProduct_picture() ?>" alt="">
						</div>
						<div class="single-prd-item">
							<img class="img-fluid" src="./../assets/images/products/<?php echo $products->getProduct_picture() ?>" alt="">
						</div>
						<div class="single-prd-item">
							<img class="img-fluid" src="./../assets/images/products/<?php echo $products->getProduct_picture() ?>" alt="">
						</div>
					</div>
				</div>
				<div class="col-lg-5 offset-lg-1">
					<div class="s_product_text">
						<h3><?php echo $products->getProduct_name() ?></h3>
						<h2>$<?php echo $products->getProduct_price() ?>.00</h2>
						<ul class="list">
							<li><a class="active" href="#"><span>วันที่โพสต์</span> : <?php echo thaidate("j F Y", $products->getProduct_update()) ?></a></li>
						</ul>
						<p><?php echo $products->getProduct_detail() ?></p>
						<div class="product_count">
							<label for="qty">จำนวน :</label>
							<input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
							<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;" class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
							<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--; return false;" class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
						</div>
						<div class="card_area d-flex align-items-center">
							<a class="primary-btn" href="javascript:addCartProduct('<?php echo $products->getProduct_key() ?>', '<?php echo $products->getProduct_price() ?>', '<?php echo $products->getProduct_name() ?>', '<?php echo $products->getProduct_picture() ?>','sst')">เพิ่มใส่ตะกร้าสินค้า</a>
						</div>
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
					<a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">รายละเอียดสินค้า</a>
				</li>
				<li class="nav-item">
					<a class="nav-link  show active" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">คอมเมนต์</a>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade " id="home" role="tabpanel" aria-labelledby="home-tab">
					<p><?php echo $products->getProduct_detail() ?></p>
				</div>
				<div class="tab-pane fade show active" id="contact" role="tabpanel" aria-labelledby="contact-tab">

					<div class="row">


						<div class="col-lg-6">
							<?php
							$commentData = $commentData === array() ? false : $commentData;
							if ($commentData) :
								foreach ($commentData as $key => $valus) :
									// print_r($valus);
									$commentGetData = new Comments();
									$commentGetData->getShowCommentsOne($valus->comment_key);
							?>
									<div class="comment_list pb-3">
										<div class="review_item">
											<div class="media">

												<div class="media-body">
													<h3><?php echo $commentGetData->getComment_title() ?></h3>
													<h5><?php echo thaidate('j F Y H:s: น.', $commentGetData->getComment_postdate()) ?></h5>
												</div>
											</div>
											<p> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $commentGetData->getComment_detail() ?></p>
										</div>

									</div>
								<?php endforeach; ?>
							<?php else : ?>
								<h4>ยังไม่มีคอมเมนต์</h4>
							<?php endif; ?>

						</div>
						<div class="col-lg-6">
							<div class="review_box">
								<h4>โพสต์คอมเมนต์</h4>
								<form class="row contact_form" action="javascript:void(0)" method="post" id="form-comment" novalidate="novalidate">
									<input type="hidden" name="account_id" value='<?php echo  $_Account->getAccount_id() ?>'>
									<input type="hidden" name="product_key" value='<?php echo $products->getProduct_key() ?>'>
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" class="form-control" id="comment_title" name="comment_title" placeholder="หัวข้อคอมเมนต์">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<textarea class="form-control" name="comment_detail" id="comment_detail" rows="5" placeholder="เนื้อหาคอมเมนต์"></textarea>
										</div>
									</div>
									<div class="col-md-12 text-right">
										<button type="submit" value="submit" class="btn primary-btn">โพสต์คอมเมนต์</button>
									</div>
								</form>

								<script>
									$("#form-comment").submit(() => {
										// warningSwal('กรุณาล็อกอินเข้าสู่ระบบก่อน', false);
										let inputs = $("#form-comment :input");
										let data = {};
										inputs.each(function() {
											data[this.name] = $(this).val();
										});
										console.log(data);

										$.ajax({
											url: "../../App/controllers/CommentsController.php",
											type: "POST",
											// dataType: "json",
											data: {
												action: "form-comment",
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
									});
								</script>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php include_once __DIR__ . '/./layouts/footer.php' ?>



</body>

</html>