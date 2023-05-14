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
	<title>สมัครสมาชิก - <?php echo $_ENV['APP_NAME']?></title>


	<?php include_once __DIR__ . '/./layouts/header.php' ?>
	<?php include_once __DIR__ . '/./layouts/script.php' ?>

</head>

<body>

	<?php include_once __DIR__ . '/layouts/navbar.php' ?>

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>สมัครสมาชิก</h1>
					<nav class="d-flex align-items-center">
						<a href="./index.php">หน้าหลัก<span class="lnr lnr-arrow-right"></span></a>
						<a href="./login.php">Login</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Login Box Area =================-->
	<section class="login_box_area section_gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 pt-5">
					<div class="login_box_img ">
						<img class="img-fluid" src="./../assets/images/pagelogin.jpg" height="100%" alt="">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="login_form_inner">
						<h3>สมัครสมาชิกเพื่อเข้าสู่ระบบ</h3>
						<form class="row login_form" action="javascript:void(0)" method="post" id="form-register" novalidate="novalidate">
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="account_name" name="account_name" placeholder="ชื่อ - สกุล" onfocus="this.placeholder = ''" onblur="this.placeholder = 'ชื่อ - สกุล'">
							</div>
							<div class="col-md-12 form-group">
								<input type="tel" class="form-control" id="account_phone" name="account_phone" placeholder="เบอร์ติดต่อ" onfocus="this.placeholder = ''" onblur="this.placeholder = 'เบอร์ติดต่อ'">
							</div>
							<div class="col-md-12 form-group">
								<input type="email" class="form-control" id="account_email" name="account_email" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control" id="account_password" name="account_password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
							</div>
							<div class="col-md-12 form-group">
								<textarea type="text" class="form-control" id="account_address" name="account_address" placeholder="ข้อมูลที่อยู่" onfocus="this.placeholder = ''" onblur="this.placeholder = 'ข้อมูลที่อยู่'" row='6'></textarea>
							</div>


							<div class="col-md-12 form-group">
								<button type="submit" name="submit" value="submit" class="primary-btn">สมัครสมาชิก</button>
								<a href="./login.php">สมัครสมาชิกแล้ว</a>
							</div>
						</form>

						<script>
							$("#form-register").submit(function(e) {
								// console.log(e);
								let inputs = $("#form-register :input");
								let data = {};
								inputs.each(function() {
									data[this.name] = $(this).val();
								});
								// console.log(body);

								$.ajax({
									url: "../../App/controllers/AccountsController.php",
									type: "POST",
									// dataType: "json",
									data: {
										action: "form-register",
										data: data,

									},
									success: function(response, statusText, jqXHR) {
										const {
											msg,
											message,
											role
										} = response ?? {};

										if (msg === "success") {
											let path = "./login.php";
											successSwal(message, path);
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
		</div>
	</section>
	<!--================End Login Box Area =================-->

	<?php include_once __DIR__ . '/./layouts/footer.php' ?>


</body>

</html>