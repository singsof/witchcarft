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
	<title>เข้าสู่ระบบ - <?php echo $_ENV['APP_NAME']?></title>


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
					<h1>Login</h1>
					<nav class="d-flex align-items-center">
						<a href="./index.php">หน้าหลัก<span class="lnr lnr-arrow-right"></span></a>
						<a href="./register.php">สมัครสมาชิก</a>
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
						<h3>ล็อกอินเพื่อเข้าสู่ระบบ</h3>
						<form class="row login_form" action="javascript:void(0)" method="post" id="form-login" novalidate="novalidate">
							<div class="col-md-12 form-group">
								<input type="email" class="form-control" id="account_email" name="account_email" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control" id="account_password" name="account_password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
							</div>
							<div class="col-md-12 form-group">
								<div class="creat_account">
									<input type="checkbox" id="remember_account" onclick="lsRememberMe()" name="checkbox">
									<label for="f-option2">ให้ฉันอยู่ในระบบ</label>
								</div>
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" name="submit" value="submit" class="primary-btn">Log In</button>
								<a href="./register.php">สมัครสมาชิก</a>
							</div>
						</form>

						<script>
							const rmCheck_Cm = document.getElementById("remember_account"),
								emailInput_Cm = document.getElementById("account_email"),
								passwordInput_Cm = document.getElementById("account_password");

							if (localStorage.checkbox_Cm && localStorage.checkbox_Cm !== "") {
								rmCheck_Cm.setAttribute("checked", "checked");
								emailInput_Cm.value = localStorage.username_Cm;
								passwordInput_Cm.value = localStorage.password_Cm;
							} else {
								rmCheck_Cm.removeAttribute("checked");
								emailInput_Cm.value = "";
								passwordInput_Cm.value = "";
							}

							function lsRememberMe() {
								if (rmCheck_Cm.checked && emailInput_Cm.value !== "" && passwordInput_Cm !== "") {
									localStorage.username_Cm = emailInput_Cm.value;
									localStorage.checkbox_Cm = rmCheck_Cm.value;
									localStorage.password_Cm = passwordInput_Cm.value;
								} else {
									localStorage.username_Cm = "";
									localStorage.checkbox_Cm = "";
									localStorage.password_Cm = "";
								}
							}
							$("#form-login").submit(function(e) {
								// console.log(e);
								let inputs = $("#form-login :input");
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
										action: "form-login",
										data: data,
									},
									success: function(response, statusText, jqXHR) {
										// console.log(response);
										const {
											msg,
											message,
											role
										} = response ?? {};

										if (msg === "success") {

											if (role === 'user') {
												// alert(role)
												successSwal(message, './../account/index.php')
											}
											if (role === 'admin') {
												successSwal(message, './../admin/index.php')
											}
							
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