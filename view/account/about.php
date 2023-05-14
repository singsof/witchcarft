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
	<title>ข้อมูลส่วนตัว - <?php echo $_ENV['APP_NAME'] ?></title>


	<?php include_once __DIR__ . '/./layouts/header.php' ?>
	<?php include_once __DIR__ . '/./layouts/script.php' ?>
</head>

<body>
	<!-- Modal -->

	<div id="show-modal"></div>
	<?php include_once __DIR__ . '/layouts/navbar.php' ?>
	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>ข้อมูลส่วนตัว</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">หน้าหลัก<span class="lnr lnr-arrow-right"></span></a>
						<a href="./about.php">ข้อมูลส่วนตัว</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Contact Area =================-->
	<section class="contact_area section_gap_bottom mt-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-4">
					<div class="contact_info">
						<div class="info_item">
							<!-- <i class="lnr lnr-home"></i> -->
							<i class="lnr lnr-user"></i>
							<h6>ชื่อ</h6>
							<p> : <?php echo $_Account->getAccount_name() ?></p>
						</div>
						<div class="info_item">
							<i class="lnr lnr-envelope"></i>
							<h6>อีเมล </h6>

							<p> : <?php echo $_Account->getAccount_email() ?></p>

						</div>
						<div class="info_item">
							<i class="lnr lnr-phone-handset"></i>
							<h6>เบอร์ติดต่อ </h6>
							<p> : <?php echo $_Account->getAccount_phone() ?></p>
						</div>
						<div class="info_item">
							<i class="lnr lnr-location"></i>
							<h6>ข้อมูลที่อยู่</h6>
							<p> : <?php echo $_Account->getAccount_address() ?></p>
						</div>
					</div>
				</div>
				<div class="col-lg-8">
					<form class="row contact_form" action="javascript:void" method="post" id="edit-about-form" novalidate="novalidate">
						<input type="hidden" name="account_id" value = "<?php echo $_Account->getAccount_id() ?>">
						<div class="col-md-6">
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="account_name" name="account_name" placeholder="ชื่อ - สกุล" onfocus="this.placeholder = ''" onblur="this.placeholder = 'ชื่อ - สกุล'" value="<?php echo $_Account->getAccount_name() ?>">
							</div>
							<div class="col-md-12 form-group">
								<input type="tel" class="form-control" id="account_phone" name="account_phone" placeholder="เบอร์ติดต่อ" onfocus="this.placeholder = ''" onblur="this.placeholder = 'เบอร์ติดต่อ'" value="<?php echo $_Account->getAccount_phone() ?>">
							</div>
							<div class="col-md-12 form-group">
								<input type="email" class="form-control" id="account_email" name="account_email" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'" value="<?php echo $_Account->getAccount_email() ?>">
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control" id="account_password" name="account_password"  placeholder="new Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'new Password'">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<textarea type="text" class="form-control" id="account_address" name="account_address" placeholder="ข้อมูลที่อยู่" onfocus="this.placeholder = ''" onblur="this.placeholder = 'ข้อมูลที่อยู่'" row='6'><?php echo $_Account->getAccount_address() ?>
							</textarea>

							</div>
						</div>
						<div class="col-md-12 text-right">
							<button type="submit" value="submit" class="primary-btn">แก้ไขข้อมูล</button>
						</div>
					</form>

					<script>
						$("#edit-about-form").submit(function(e) {
							// console.log(e);
							let inputs = $("#edit-about-form :input");
							let data = {};
							inputs.each(function() {
								data[this.name] = $(this).val();
							});
							// console.log(data);
							// successSwal('message');
							$.ajax({
								url: "../../App/controllers/AccountsController.php",
								type: "POST",
								// dataType: "json",
								data: {
									action: "edit-about-form",
									data: data,

								},
								success: function(response, statusText, jqXHR) {
									// console.log(response);
									const {
										msg,
										message
									} = response ?? {};

									if (msg === "success") {
										successSwal(message,true);
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
				</div>
			</div>
		</div>
	</section>
	<!--================Contact Area =================-->
	<?php include_once __DIR__ . '/./layouts/footer.php' ?>

</body>

</html>