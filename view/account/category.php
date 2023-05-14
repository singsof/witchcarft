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
	<title>รายการสินค้า - <?php echo $_ENV['APP_NAME']?></title>

	<?php include_once __DIR__ . '/./layouts/header.php' ?>
	<?php include_once __DIR__ . '/./layouts/script.php' ?>

</head>

<body>

	<?php include_once __DIR__ . '/layouts/navbar.php' ?>

	<script>
		// successSwal('lskdjf');
	</script>

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>หน้าร้านค้า</h1>
					<nav class="d-flex align-items-center">
						<a href="./index.php">หน้าหลัก<span class="lnr lnr-arrow-right"></span></a>
						<a href="./category.php">Shop</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->
	<div class="container mb-5">
		<div class="row">

			<?php

			$ProductModel = new Products();
			$productList = null;
			$Getsearch = isset($_GET['search']) && $_GET['search'] != '' ? '%' . $_GET['search'] . '%' : "%%";
			$sort = isset($_GET['sort']) ? $_GET['sort'] : 'product_key';
			$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$limit = 10;
			$start = ($page - 1) * $limit; // 2-1 *10
			$i = 1;

			$total = count($ProductModel->getSelectProducts("product_name LIKE '$Getsearch' AND (product_status != 'delete' AND product_status != 'hide')"));
			// $total =  DB::query("SELECT * FROM `products` WHERE product_name LIKE '$Getsearch' AND (product_status != 'delete' AND product_status != 'hide')")->fetchColumn(); //sum results
			$total_pages = ceil($total / $limit);
			$sqlPro = "product_name LIKE '$Getsearch' AND (product_status != 'delete' AND product_status != 'hide') ORDER BY `products`.`$sort` $order LIMIT $start, $limit ";
			$stmt = $ProductModel->getSelectProducts($sqlPro);
			$productList = $stmt;
			// var_dump($total);
			?>

			<div class="col-xl-12 col-lg-11 col-md-10">
				<!-- Start Filter Bar -->
				<div class="filter-bar d-flex flex-wrap align-items-center">
					<div class="sorting">
						<select name="sort-by"  onChange="sortBy(this);">
							<option value="&amp;sort=product_key&amp;order=ASC" <?php echo isset($_GET["sort"]) && $_GET["sort"] == 'product_key' && isset($_GET['order']) && $_GET['order'] == 'ASC' ? 'selected="selected "' : " " ?>>สินค้าใหม่</option>
							<option value="&amp;sort=product_name&amp;order=ASC" <?php echo isset($_GET["sort"]) && $_GET["sort"] == 'product_name' && isset($_GET['order']) && $_GET['order'] == 'ASC' ? 'selected="selected "' : " " ?>>ชื่อ (A - Z)</option>
							<option value="&amp;sort=product_name&amp;order=DESC" <?php echo isset($_GET["sort"]) && $_GET["sort"] == 'product_name' && isset($_GET['order']) && $_GET['order'] == 'DESC' ? 'selected="selected "' : " " ?>>ชื่อ (Z - A)</option>
							<option value="&amp;sort=product_price&amp;order=ASC" <?php echo isset($_GET["sort"]) && $_GET["sort"] == 'product_price' && isset($_GET['order']) && $_GET['order'] == 'ASC' ? 'selected="selected "' : " " ?>>ราคา (ต่ำ &gt; สูง)</option>
							<option value="&amp;sort=product_price&amp;order=DESC" <?php echo isset($_GET["sort"]) && $_GET["sort"] == 'product_price' && isset($_GET['order']) && $_GET['order'] == 'DESC' ? 'selected="selected "' : " " ?>>ราคา (สูง &gt; ต่ำ)</option>

						</select>
					</div>
					<div class="sorting mr-auto">
						
					</div>
					<div class="sorting ">
						<!-- <div class="input-group">
							<input type="text" class="form-control" placeholder="ค้นหาชื่อสินค้า">
							<button class="btn btn-outline-primary" type="button">ค้นหา</button>
						</div> -->
						<div class="input-group input-group-lg  ">
							<input id="search-name" type="text" class="form-control" value="<?php echo isset($_GET['search']) ? $_GET['search'] : "" ?>" placeholder="ค้นหาจากชื่อสินค้า" aria-label="ค้นหาจากชื่อสินค้า" aria-describedby="button-addon2">
							<div class="input-group-append">
								<button class="btn btn-sm primary-btn" onclick="search_name('search-name')" type="button" id="button-addon2">ค้นหา</button>
							</div>
						</div>
					</div>
				</div>
				<!-- End Filter Bar -->
				<!-- Start Best Seller -->
				<section class="lattest-product-area pb-40 category-list">
					<div class="row">
						<!-- single product -->
						<?php
						foreach ($productList as $key => $values) :
							$productData = new Products();
							$productData->setProduct_key($values->product_key);
							$productData->setProduct_name($values->product_name);
							$productData->setProduct_price($values->product_price);
							$productData->setProduct_stock($values->product_stock);
							$productData->setProduct_picture($values->product_picture);
							$productData->setProduct_detail($values->product_detail);


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
					<?php if ($total === 0) : ?>

						<h3 class="mb-5 mt-5">ไม่พบข้อมูลรายการสินค้า</h3>

					<?php endif; ?>
				</section>
				<!-- End Best Seller -->
				<!-- Start Filter Bar -->
				<div class="filter-bar d-flex flex-wrap align-items-center">
					<div class="sorting mr-auto">

					</div>
					<div class="pagination">
						<?php if ($page > 1) : ?>
							<a href="./category.php?page=<?php echo $page - 1 ?>" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
							<!-- <li class="page-item"><a class="page-link" href="./category.php?page=<?php echo $page - 1 ?>"><i class="fas fa-angle-double-left"></i></a></li> -->
						<?php endif; ?>

						<?php for ($pagei = 1; $pagei <= $total_pages; $pagei++) :
							//if its active page add active variable
							if ($page == $pagei) {
								$class = 'active';
							} else {
								$class = '';
							}
						?>
							<a href="./category.php?page=<?php echo $pagei ?>" class="<?php echo $class; ?>"><?php echo $pagei ?></a>
						<?php endfor; ?>


						<?php
						if ($page < $total_pages) :
						?>
							<a href="./category.php?page=<?php echo $page + 1 ?>" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
						<?php endif; ?>



						<!-- <a href="#" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
						<a href="#" class="active">1</a>
						<a href="#">2</a>
						<a href="#">3</a>
						<a href="#" class="dot-dot"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
						<a href="#">6</a>
						<a href="#" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a> -->
					</div>
				</div>
				<!-- End Filter Bar -->
			</div>
		</div>
	</div>


	<?php include_once __DIR__ . '/./layouts/footer.php' ?>


</body>

</html>