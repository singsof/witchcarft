	<!-- start footer Area -->
	<footer class="footer-area p-0">
		<!-- <div class="container"> -->
		<div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
			<p class="footer-text m-0 p-5 "><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
				Copyright &copy;<script>
					document.write(new Date().getFullYear());
				</script> ลิขสิทธิ์ © 2023 สงวนลิขสิทธิ์ <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="javascript:void(0)" target="_blank"><?php echo $_ENV['APP_NAME'] ?></a>
				<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
			</p>
		</div>
		<!-- </div> -->
	</footer>

	<script>
		$(".table-neme").DataTable({
			dom: "IBfrtip",
			lengthMenu: [
				[10, 25, 50, 60, -1],
				[10, 25, 50, 60, "All"],
			],
			language: {
				sProcessing: "กำลังดำเนินการ...",
				sLengthMenu: "แสดง  _MENU_  แถว",
				sZeroRecords: "ไม่พบข้อมูล",
				sInfo: "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
				sInfoEmpty: "แสดง 0 ถึง 0 จาก 0 แถว",
				sInfoFiltered: "(กรองข้อมูล _MAX_ ทุกแถว)",
				sInfoPostFix: "",
				sSearch: "ค้นหา: ",
				sUrl: "",
				oPaginate: {
					sFirst: "เริ่มต้น",
					sPrevious: "ก่อนหน้า",
					sNext: "ถัดไป",
					sLast: "สุดท้าย",
				},
			}, // sInfoEmpty: "แสดง 0 ถึง 0 ของ 0 เร็คคอร์ด",
			processing: true, // แสดงข้อความกำลังดำเนินการ กรณีข้อมูลมีมากๆ จะสังเกตเห็นง่าย
			//serverSide: true, // ใช้งานในโหมด Server-side processing
			// กำหนดให้ไม่ต้องการส่งการเรียงข้อมูลค่าเริ่มต้น จะใช้ค่าเริ่มต้นตามค่าที่กำหนดในไฟล์ php
			retrieve: true,
			buttons: ["excel"],
		});
	</script>
	<!-- End footer Area -->