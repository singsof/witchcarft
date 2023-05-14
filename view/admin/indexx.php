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
	<title>หน้าหลัก - <?php echo $_ENV['APP_NAME'] ?></title>


	<?php include_once __DIR__ . '/./layouts/header.php' ?>
	<?php include_once __DIR__ . '/./layouts/script.php' ?>
</head>

<body style="background-color: #A9A9A9;">
	<!-- Modal -->

	
	<?php include_once __DIR__ . '/layouts/navbar.php' ?>
	<!-- start banner Area -->
	<section class="banner-area">
		<div class="container">
			<div class="row fullscreen align-items-center justify-content-start">
				<div class="col-lg-12">
					<div class="active-banner-slider owl-carousel">

						<?php
						$tarotCard = new TarotCards();
						$tarotCardData = $tarotCard->getShowTarotCardsAll();

						foreach ($tarotCardData as $key => $value) :
							$tarotCard->getShowTarotCardsOne($value->card_key)
						?>
							<!-- single-slide -->
							<div class="row single-slide align-items-center d-flex">
								<div class="col-lg-5 col-md-6">
									<div class="banner-content">
										<h1>ไพ่ยิปซี</h1>
										<p>ไพ่ยิปซี มีจุดกำเนิดมาจากชาวยิปซีโบราณ ที่นิยมใช้แพร่หลายไปทั่วโลกโดยศาสตร์นี้เขาร่ำลือกันว่ามีความเร้นลับที่ไม่สามารถอธิบายได้โดยการทำนายของไพ่ยิปซีนี้จะใช้ “จิต” ในการทำนายเพราะเชื่อว่าจิตอยู่เหนือร่างกายและทุกสิ่งทุกอย่างวิถีชีวิตความเป็นไปจิตจะเป็นผู้กำหนด ดังนั้นในการพยากรณ์ด้วย ไพ่ยิปซี จะต้องใช้สมาธิจิต รวมไว้ที่ไพ่โดยให้ไพ่เป็นเพียงสื่อกลาง รูปและสัญลักษณ์บนไพ่ที่หยิบได้สื่อสารบอกเล่าความหมาย เรื่องราวต่าง ๆ ที่จะเกิดขึ้นนั่นเอง</p>
									</div>
								</div>
								<div class="col-lg-7">
									<div class="banner-img">
										<img style="width: 250px; height: auto;" class="" src="./../assets/images/banr1.jpg" alt="">
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End banner Area -->

	<!-- start features Area -->
	<section class="features-area section_gap">
		<div class="container">
			<div class="row features-inner">
				<!-- single features -->
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="single-features">
						<div class="f-icon">
							<img src="./../assets/img/features/f-icon1.png" alt="">
						</div>
						<h6> Cheap Delivery</h6>
						<p>Delivery 30฿ on All Orders</p>
					</div>
				</div>
				<!-- single features -->
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="single-features">
						<div class="f-icon">
							<img src="./../assets/img/features/f-icon2.png" alt="">
						</div>
						<h6>Return Policy</h6>
						<p>Free Return Policy</p>
					</div>
				</div>
				<!-- single features -->
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="single-features">
						<div class="f-icon">
							<img src="./../assets/img/features/f-icon3.png" alt="">
						</div>
						<h6>Support</h6>
						<p>24 hour support</p>
					</div>
				</div>
				<!-- single features -->
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="single-features">
						<div class="f-icon">
							<img src="./../assets/img/features/f-icon4.png" alt="">
						</div>
						<h6>Secure Payment</h6>
						<p>Trust us with every payment.</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section>
		<!-- single product slide -->
		<div class="single-product-slider">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-6 text-center">
						<div class="section-title">
							<h1>หยิบไพ่ดูดวง</h1>
							<p>สินค้าชิ้นไดที่เหมาะกับคุณ คลิกที่ภาพข้างล่างนี้เลย</p>
						</div>
					</div>
				</div>
				<div class="row">
					<?php
					shuffle($tarotCardData);
					foreach ($tarotCardData as $key => $value) :
						$tarotCardTo = new TarotCards();
						$tarotCardTo->getShowTarotCardsOne($value->card_key)
					?>
						<div class="col-lg-3 col-md-6">
							<div class="single-product">
								<a href="javascript:ModaldetailCard(<?php echo $tarotCardTo->getCard_key() ?>); ">
									<img class="img-fluid" src="./../assets/images/tarotcards/back.png" alt="">
								</a>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
	<!-- end product Area -->
	<script>
		const ModaldetailCard = (card_key) => {

			Swal.fire({
				imageUrl: './../assets/images/tarotcards/back.png',
				imageWidth: 300,
				imageHeight: 500,
				title: 'คุณแน่ใจว่าเลือกใบนี้',
				text: "คุณจะเปลี่ยนกลับไม่ได้!",
				// icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'เลือกใบนี้',
				cancelButtonText: 'เลือกใหม่'
			}).then((result) => {
				if (result.isConfirmed) {

					let timerInterval
					Swal.fire({
						title: 'โปรดรอสักครู่',
						html: 'กรุณาปล่อยมือออกจากเมาส์ และคีย์บอร์ดรออีก ( <b></b> ) มิลลิวินาที',
						timer: 3000,
						timerProgressBar: true,
						didOpen: () => {
							Swal.showLoading()
							const b = Swal.getHtmlContainer().querySelector('b')
							timerInterval = setInterval(() => {
								b.textContent = Swal.getTimerLeft()
							}, 100)
						},
						willClose: () => {
							
							clearInterval(timerInterval)

						}
					}).then((result) => {
						/* Read more about handling dismissals below */
						if (result.dismiss === Swal.DismissReason.timer) {
							console.log('I was closed by the timer')
							location.assign('./carddetails.php?card_key='+card_key);
						}
					})
				}
			})

		};
	</script>


	<?php include_once __DIR__ . '/./layouts/footer.php' ?>

	<?php include_once __DIR__ . '/./layouts/script.php' ?>

</body>

</html>